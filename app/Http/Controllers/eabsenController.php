<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class eabsenController extends mesinFinger
{

  public function dteabsen_dp_af($id)
  {
      $datafromeabsen = file_get_contents("http://eabsen.kalselprov.go.id/api/cekpegawai/".$id);
      $decode_c= json_decode($datafromeabsen);
      //return $datafromeabsen;
      return datatables()->of($decode_c)->toJson();
  }

    public function eabsen_dp()
    {
      return view('eabsen_dp');
    }

    public function eabsen_uf()
    {
      return view('eabsen_uf');
    }

    public function eabsen_df()
    {
      return view('eabsen_df');
    }
}
