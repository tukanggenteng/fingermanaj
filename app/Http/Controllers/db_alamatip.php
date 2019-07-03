<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models Database
use App\Alamatip;

class db_alamatip extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alamatip = Alamatip::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
          'alamatip' => 'required|min:8|max:16|unique:alamatips,alamat',
        ]);
        $alamat_ip = Alamatip::all();
        if(count($alamat_ip)<10)
        {
          $alamatip = new Alamatip([
            'alamat' => $request->alamatip,
            'status' => 0,
          ]);
          $alamatip->save();

          return redirect()->route('mesin.konfig')->with('success_ip', 'Alamat IP sudah ditambahkan!');
        }
        else {
          return redirect()->route('mesin.konfig')->with('pesan_ip', 'Alamat IP tidak boleh lebih dari 10!');
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
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
          'alamat'=>'required|unique:alamatips',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->withErrors($validator)
                        ->withInput();
        }

        $alamatip = Alamatip::find($request->id);
        $alamatip->alamat = $request->alamatip;
        $alamatip->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $alamatip = Alamatip::find($id);
      $alamatip->delete();
      return redirect()->route('mesin.konfig')->with('pesan_ip', 'Alamat IP berhasil dihapus!');
    }
}
