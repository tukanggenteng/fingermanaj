<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models Database
use App\Instansi;

class db_instansi extends Controller
{
    public function dt_instansi()
    {
       $data_instansi = Instansi::all();
       return datatables()->of($data_instansi)->toJson();
    }

    public function data_instansi_v()
    {
       return view('daftar_instansi');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'ID'=>'required|integer|unique:instansis',
          'kode'=> 'required',
          'namaInstansi' => 'required',
        ]);

        if ($validator->fails()) {
            $response['masalah'] = $validator->errors();
            return $response;
            //return redirect()
            //            ->withErrors($validator)
            //            ->withInput();
        }

        $instansi = new Instansi([
          'id' => $request->ID,
          'kode' => $request->kode,
          'namaInstansi' => $request->namaInstansi,
        ]);
        $instansi->save();

        $response = array();
        $response['id'] = $request->ID;
        $response['kode'] = $request->kode;
        $response['namaInstansi'] = $request->namaInstansi;
        $response['modal_id'] = $request->modal_id;
        $response['pesan'] = 'Data '.$response['id'].':'.$response['namaInstansi'].' berhasil ditambahkan!';
        $response['status'] = "1";

        return $response;

    }

    public function testing(Request $request)
    {
        //jika pengen testing
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
      $validator = Validator::make($request->all(), [
        'ID'=>'required|integer',
        'kode'=> 'required',
        'namaInstansi' => 'required',
      ]);

      if ($validator->fails()) {
          $response['masalah'] = $validator->errors();
          return $response;
          //return redirect()
          //            ->withErrors($validator)
          //            ->withInput();
      }

      $instansi = Instansi::find($request->ID);
      $instansi->kode = $request->kode;
      $instansi->namaInstansi = $request->namaInstansi;
      $instansi->save();

      $response = array();
      $response['id'] = $request->ID;
      $response['kode'] = $request->kode;
      $response['namaInstansi'] = $request->namaInstansi;
      $response['modal_id'] = $request->modal_id;
      $response['pesan'] = 'Data '.$response['id'].':'.$response['namaInstansi'].' berhasil diperbaharui!';
      $response['status'] = "1";

      return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

      $instansi = Instansi::find($request->ID);
      $instansi->delete();

      $response = array();
      $response['id'] = $request->ID;
      $response['kode'] = $request->kode;
      $response['namaInstansi'] = $request->namaInstansi;
      $response['modal_id'] = $request->modal_id;
      $response['pesan'] = 'Data '.$response['id'].':'.$response['namaInstansi'].' berhasil dihapus!';
      $response['status'] = "1";

      return $response;
    }

    //bisa juga diarahkan ke data eabsen langsung http://eabsen.kalselprov.go.id/instansi/cari/
    public function cari(Request $request){
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $tags = instansi::where('namaInstansi','LIKE','%'.$term.'%')->limit(5)->get();
        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->namaInstansi];
        }
        return response()->json($formatted_tags);
    }
}
