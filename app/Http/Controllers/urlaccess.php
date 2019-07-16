<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//DB
use App\ServerAccs;

class urlaccess extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
      $this->validate($request, [
        'url_server' => 'required|min:5|unique:serveraccs,url_server',
      ]);
      $alamat_sv = ServerAccs::all();
      if(count($alamat_sv)<5)
      {
        $alamat_sv = new ServerAccs([
          'url_server' => $request->url_server,
          'status' => 0,
        ]);
        $alamat_sv->save();

        return redirect()->route('mesin.konfig')->with('success_sv', 'Alamat Server sudah ditambahkan!');
      }
      else {
        return redirect()->route('mesin.konfig')->with('pesan_sv', 'Alamat Server tidak boleh lebih dari 5!');
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
    public function update(Request $request) //(Request $request, $id)
    {

      //normalize
      DB::table('serveraccs')->update(['status'=> 0]);

      $server = ServerAccs::where('url_server', $request->url_server)->update(['status' => 1]);

      $response = array();
      $response['url_server'] = $request->url_server;
      $response['pesan'] = 'Data '.$response['url_server'].' berhasil diperbaharui!';
      $response['status'] = "1";

      return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //($id)
    {
      $serveraccs = ServerAccs::find($id);
      $serveraccs->delete();
      return redirect()->route('mesin.konfig')->with('pesan_sv', 'Alamat Server berhasil dihapus!');
    }
}
