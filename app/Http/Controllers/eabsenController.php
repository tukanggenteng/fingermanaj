<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class eabsenController extends mesinFinger
{

  // Download Data Pegawai yang sudah memiliki Sidik Jari
  public function dteabsen_dp_af($id)
  {
      //$ch = curl_init();
      //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      //curl_setopt($ch,CURLOPT_URL,"http://eabsen.kalselprov.go.id/api/cekpegawai/".$id);
      //curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
      //$data = curl_exec($ch);
      //curl_close($ch);

      $datafromeabsen = file_get_contents("http://eabsen.kalselprov.go.id/api/cekpegawai/".$id);
      $decode_c= json_decode($datafromeabsen);
      //return $datafromeabsen;
      return datatables()->of($decode_c)->toJson();
  }
  // ./Download Data Pegawai yang sudah memiliki Sidik Jari

  // Download Data Pegawai yang BELUM memiliki Sidik Jari
  public function eabsen_dp_tf($id)
  {
      $data_fps = file_get_contents("http://eabsen.kalselprov.go.id/api/cekpegawai/".$id);
      $p_sdhfinger= json_decode($data_fps);

      $data_p = file_get_contents("http://eabsen.kalselprov.go.id/api/cekpegawai/data/".$id);
      $p_semua= json_decode($data_p);

      $hpmsua = count($p_semua);
      $hsdhf = count($p_sdhfinger);

      $p_blmfinger = array();

      for($i=0; $i<$hpmsua; $i++)
      {
         $status = FALSE;
         for($j=0; $j<$hsdhf; $j++)
         {
            if( $p_semua[$i]->id == $p_sdhfinger[$j]->id) { $status = TRUE; break; }
         }
         if($status==FALSE)
         {
            $p_blmfinger[] = array(
                'id' => $p_semua[$i]->id,
                'nip' => $p_semua[$i]->nip,
                'nama' => $p_semua[$i]->nama,
            );
         }
      }

      return $p_blmfinger;
  }
  // ./Download Data Pegawai yang BELUM memiliki Sidik Jari

  // data table untuk yang belum finger=====================
  public function dteabsen_dp_tf($id)
  {
      $databelumfinger = $this->eabsen_dp_tf($id);
      return datatables()->of($databelumfinger)->toJson();
  }
  //=========================================================

  // data yang belum finger untuk ke mesin===================
  public function deabsen_dp_tf($id)
  {
      $databelumfinger = $this->eabsen_dp_tf($id);
      return $databelumfinger;
  }
  //=========================================================

  //Download data sidik jari berdasarkan ID pegawai
  public function deabsen_down_fp(Request $request)
  {
    $id = $request->id;
    $nama = $request->nama;
    $mesin = new mesinFinger;
    //$response = array();

    $data_down_fp = file_get_contents("http://eabsen.kalselprov.go.id/api/ambilfinger/".$id);
    $p_finger_d = json_decode($data_down_fp); //format datanya adalah object
    $jumlah_dfp = count($p_finger_d);
    //$response = $p_finger_d[0]->id;
    if($jumlah_dfp>0)
    {
        $jumlah_Temfp = strlen($p_finger_d[0]->templatefinger); //hitung panjang templatefinger untuk menentkan PIN atau Sidik Jari
        if($jumlah_Temfp <= 8) // password/PIN
        {
          //Data, posisi harus disini karena array dan untuk mengecek index
          $request->ID = $p_finger_d[0]->pegawai_id;
          $request->nama = $nama;
          $request->FingerID = 0;
          $request->size = $p_finger_d[0]->size;
          $request->template_finger = $p_finger_d[0]->templatefinger;
          //----
          $setData = $mesin->tambahNamaPegawai($request);

          $response[0] = array(
              'status' => $setData['status'],
              'nama' => $nama,
              'id' => $request->ID,
              'jenis' => 'PIN/Password',
            );
        }
        else if($jumlah_Temfp > 8) // Sidik Jari
        {
          for($i=0; $i<$jumlah_dfp; $i++)
          {
            //Data, posisi harus disini karena array dan untuk mengecek index
            $request->ID = $p_finger_d[$i]->pegawai_id;
            $request->FingerID = $i;
            $request->size = $p_finger_d[$i]->size;
            $request->template_finger = $p_finger_d[$i]->templatefinger;
            //----
            $setData = $mesin->setDataFingerCore($request);

            $response[$i] = array(
                'status' => $setData['status'],
                'nama' => $nama,
                'id' => $request->ID,
                'FingerID' => $request->FingerID,
                'size' => $request->size,
                'template' => $request->template_finger,
                'jenis' => 'Sidik Jari',
              );

              /* //no problemmo
              $response[$i] = array(
                 'id' => $p_finger_d[$i]->pegawai_id,
                 'FingerID' => $p_finger_d[$i]->id,
                 'size' => $p_finger_d[$i]->size,
                 'template' => $p_finger_d[$i]->templatefinger,
               );
               */
          }
        }

    }
    else
    {
        $response = 'Pegawai masih belum mempunyai data Sidik Jari/PIN!';
    }

    //$response = $jumlah_dfp;
    return $response;
  }
  //./Download data sidik jari berdasarkan ID pegawai


  //Upload data Sidik Jari/PIN/Password dari mesin
  public function deabsen_up_proses(Request $request)
  {
      $iddarimesin = $request->iddarimesin;
      $iddarieabsen = $request->iddarieabsen;
      $nama = $request->nama;
      $mesin = new mesinFinger;
      $datapegawai = $mesin->cekdatapegawai_tunggal($id);
      //$datapegawai = $mesin->cekdatapegawai_finger();

      $response = array();
      //cek data pegawai dulu, untuk mengetahui ada atau tidaknya data password,
      //jika tidak ada proses untuk upload data finger
      if(empty($datapegawai['Password'])) //prosesfp
      {
          $request->ID = $id;
          //$fp = $mesin->hapusDataFingerCore($request);
          //kemudian cek ketersedian data sidik jari pada mesin
          $fp = $mesin->cekdatafinger_p($id, $i);

      }
      else //prosesPin
      {
          $request->ID = $id;
          //$pass = $mesin->ClearUserPasswordCore($request);
          //eksekusi upload data Pssword/PIN
      }


      $response = array(
          'status' => $status, //data dari fungsi mesin
          'nama' => $nama,
          'id' => $request->ID,
          'jenis' => $jenis,
        );


      return $response;
  }
  //get data pass/pin then upload
  public function deabsen_up_passpin($id)
  {
    $mesin = new mesinFinger;
    $datapegawai = $mesin->cekdatapegawai_tunggal($id);
    $upload = array();

    for($i=0;$i<2;$i++)
    {
        $upload = array(
          'pegawai_id' => $id,
          'size' => strlen($datapegawai['Password']),
          'valid' => 1,
          'templatefinger' => $datapegawai['Password'],
        );

    }

    $jenis = 'Password/PIN';
    $status = $pass['status'];
  }
  //get data fingerprint then upload
  public function deabsen_up_fp($id)
  {
    $mesin = new mesinFinger;

    for($i=0;$i<2;$i++)
    {
        $fp = $mesin->cekdatafinger_p($id, $i);
        $upload = array(
          'pegawai_id' => $id,
          'size' => strlen($datapegawai['Password']),
          'valid' => 1,
          'templatefinger' => $datapegawai['Password'],
        );

        $jenis = 'Sidik jari';
        $status = $fp['status'];
    }
  }
  // END./Upload data Sidik Jari/PIN/Password dari mesin


  //Menghapus data Sidik Jari/PIN/Password pada mesin
  // Hapus data Password/Pin/sidik jari berdasarkan ID pegawai
  public function deabsen_del(Request $request)
  {
    $id = $request->ID;
    $nama = $request->nama;
    $mesin = new mesinFinger;
    $datapegawai = $mesin->cekdatapegawai_tunggal($id);

    $response = array();
    //cek data pegawai dulu, untuk mengetahui ada atau tidaknya data password,
    //jika tidak ada hapus finger
    if(empty($datapegawai['Password']))
    {
        $request->ID = $id;
        $fp = $mesin->hapusDataFingerCore($request);
        $jenis = 'Sidik jari';
        $status = $fp['status'];
    }
    else
    {
        $request->ID = $id;
        $pass = $mesin->ClearUserPasswordCore($request);
        $jenis = 'Password/PIN';
        $status = $pass['status'];
    }


    $response = array(
        'status' => $status, //data dari fungsi mesin
        'nama' => $nama,
        'id' => $request->ID,
        'jenis' => $jenis,
      );


    return $response;
  }
  // ./Hapus data Password/Pin/sidik jari berdasarkan ID pegawai------------------


  // Fungsi View Interface-----------------------------------------------------------------------------
    public function eabsen_dp()
    {
      //cek koneksi biar fungsi ----------------------------------------------------------------
      $mesin = new mesinFinger;
      $kon = $mesin->connHealthCheck(session('set_ip'));
      if($kon=='dead')
      {
         return redirect()->route('mesin.konfig')->with('pesan', 'Alat fingerprintscan tidak bisa dihubungi, silakan setting ulang alamat IP !');
      }
      // ./cek koneksi biar fungsi ----------------------------------------------------------------
      return view('eabsen_dp');
    }

    public function eabsen_uf()
    {
      $redir = $this->redirectToDp();
      if(empty($redir->datapegawai)) { return redirect()->route('eabsen.dp')->with($redir->d_session, $redir->d_session_msg); }

      return view('eabsen_uf');
    }

    public function eabsen_df()
    {
      //cek data pegawai di msin fingerprint, jika belum redirect ke halaman download data pegawai
      $redir = $this->redirectToDp();
      if(empty($redir->datapegawai)) { return redirect()->route('eabsen.dp')->with($redir->d_session, $redir->d_session_msg); }
      //----------

      return view('eabsen_df');
    }

    public function redirectToDp()
    {
      //cek data pegawai di msin fingerprint, jika belum redirect ke halaman download data pegawai
      $mesin = new mesinFinger;
      $redirect = new mesinFinger;
      //$redirect = array();
      $redirect->datapegawai = $mesin->cekdatapegawai_finger();
      $redirect->d_session = 'pesan';
      $redirect->d_session_msg = 'Data Pegawai masih kosong, silahkan tambah data pegawai!';

      // set kondisi redirect pada fungsi view
      /*
      if(empty($datapegawai))
      {
        redirect()->route('eabsen.dp')->with('pesan', 'Data Pegawai masih kosong, silahkan tambah data pegawai!');
      }
      */
      return $redirect;
    }
    // ./Fungsi View Interface-----------------------------------------------------------------------------

}
