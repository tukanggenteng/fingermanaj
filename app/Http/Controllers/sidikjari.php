<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models Database
use App\Sidikjaris;

class sidikjari extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('daftar_sidikjari');
    }
    public function dtsidikjari()
    {
      $data_fp = Sidikjaris::select('id','pegawai_id','created_at','updated_at');
      return datatables()->of($data_fp)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mesin = app('App\Http\Controllers\mesinFinger');
        $data = $mesin->cekdatapegawai_tunggal(56);
        dd($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //nanti ganti fungsi back up saja
    {
      $iddarimesin = $request->iddarimesin;
      $iddarieabsen = $request->iddarieabsen;
      $nama = $request->nama;
      $mesin = app('App\Http\Controllers\mesinFinger');
      $datapegawai = $mesin->cekdatapegawai_tunggal($iddarimesin);
      //$datapegawai = $mesin->cekdatapegawai_finger();

      $response = array();
      //cek data pegawai dulu, untuk mengetahui ada atau tidaknya data password,
      //jika tidak ada proses untuk upload data finger
      if(!empty($datapegawai['Password'])) //prosesPin
      {
          $status = "2";
          $jenis = 'PIN';
          $status_pesan = "Data PIN tidak akan diBackup!";
      }
      else //prosesfp
      {
          $request->ID = $iddarimesin;
          //$fp = $mesin->hapusDataFingerCore($request);
          //kemudian cek ketersedian data sidik jari pada mesin
          $fp = $mesin->cekdatafinger_p($iddarimesin, 0);
          if(!empty($fp['Template']))
          {
            //eksekusi perintah upload
            $up_fp = $this->deabsen_up_fp($iddarimesin, $iddarieabsen);
            $status = '1';
            $jenis = 'Sidik Jari';
            $status_pesan = $up_fp[0]['status pesan'];

          }
          else
          {
            $status = '0';
            $jenis = 'Tidak ada Data Sidik Jari pada mesin!';
            $status_pesan ='';
          }
      }


      $response = array(
          'status' => $status, //data dari fungsi mesin
          'status_pesan' => $status_pesan,
          'nama' => $nama,
          'id' => $request->$iddarieabsen,
          'jenis' => $jenis,
        );

      return $response;
    }
    //get data fingerprint then backup
    public function deabsen_up_fp($id_m, $id_ea)
    {
      $mesin = app('App\Http\Controllers\mesinFinger');

      for($i=0;$i<2;$i++)
      {
          $fp = $mesin->cekdatafinger_p($id_m, $i);

          $sidikjari = new Sidikjaris([
            'pegawai_id' => $id_ea,
            'size' => $fp['Size'],
            'valid' => 1,
            'templatefinger' => $fp['Template'],
          ]);
          $sidikjari->save();
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fp = Sidikjaris::find($id);
        return $fp;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $instansi = Sidikjaris::find($request->id);
      $instansi->delete();

      $response = array();
      $response['id'] = $request->id;
      $response['pegawai_id'] = $request->pegawai_id;
      $response['modal_id'] = $request->modal_id;
      $response['pesan'] = 'Data '.$response['id'].':'.$response['pegawai_id'].' berhasil dihapus!';
      $response['status'] = "1";

      return $response;
    }
}
