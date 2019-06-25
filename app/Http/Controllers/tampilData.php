<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class tampilData extends mesinFinger
{
  //---------------------------------------------------------------------------------------------------------------------------------
  //memanggil data Figer pegawai dari fungsi cekdatapegawai_finger() for datatable
  public function datapegawai_finger()
  {
      $mesin = new mesinFinger;
      return datatables()->of($mesin->cekdatapegawai_finger())->toJson();
      //dd($this->cekdatapegawai_finger());
  }
  //END.------------------------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------------------------
  //memanggil data Figer pegawai dari fungsi cekdatapegawai_finger() for datatable
  public function datapegawai_finger_view()
  {
    return view('datapegawai_m');
  }
  //END.------------------------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------------------------
  //menampilkan data Figer pegawai di alat finger
  public function datafinger_p($id,$nama) //id nanti diambil dari variable yang dilempar oleh fungsi data pegawai
  {
    //  <GetUserTemplateResponse>
    //  <Row><PIN>7239</PIN><FingerID>1</FingerID><Size>1494</Size><Valid>1</Valid><Template>TJVTUzIxAAAF1txx</Template></Row> ◀
    //  </GetUserTemplateResponse>

    return view('datafingerpegawai_m',[ 'ID' => $id, 'nama' => $nama ]);

  }
  //END.------------------------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------------------------
  //menampilkan data Figer pegawai dari alat finger sekaligus melakukan edit
  public function cekdatafinger_p_v($id,$nama, $jari) //id nanti diambil dari variable yang dilempar oleh fungsi data pegawai
  {
    $mesin = new mesinFinger;
    $datafinger = array();
    $datafinger = $mesin->cekdatafinger_p($id,$jari);
    //dd($datafinger);
    return view('datafingerpegawai_m_v',[ 'ID'=>$id,'nama'=>$nama, 'datafinger' => $datafinger ]);
  }
  //END.------------------------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------------------------
  //untuk mengisikan data Figer pegawai pada alat finger dengan data sidik jari yang kosong
  public function cekdatafinger_p_vt($id,$nama, $jari) //id nanti diambil dari variable yang dilempar oleh fungsi data pegawai
  {
    //dd($datafinger);
    return view('datafingerpegawai_m_vt',[ 'ID'=>$id,'nama'=>$nama, 'jari' => $jari ]);
  }
  //END.------------------------------------------------------------------------------------------------------------------------------



  // fungsi konfigurasi
  function checkMac()
	{
		  //dd($template);
      $mesin = new mesinFinger;
      $Connect = fsockopen($mesin->ip, "80", $errno, $errstr, 1);

	    $nama = '~SerialNumber';
      //$nama = 'MAC'; //opsi menggunakan data MAC Address
      $soap_request= $mesin->GetOption($nama);
      $buffer="";
      $buffer = $mesin->SoapConnect($Connect, $soap_request, $buffer); //harus didefiniskan sebagai variable agar menyimpan data

      //Response data
	    // dd($buffer); //cek sebagai format xml
      $buffer= $mesin->Parse_Data($buffer,"<GetOptionResponse>","</GetOptionResponse>");
      $buffer=explode("\r\n",$buffer);

      $dataabsensi = array();

      for($i=0;$i<count($buffer);$i++)
      {
        $data = $mesin->Parse_Data($buffer[$i],"<Row>","</Row>");
        if($mesin->Parse_Data($data,"<Value>","</Value>")!="")
        {
          $dataabsensi = array(
                                'Value' => $mesin->Parse_Data($data,"<Value>","</Value>"),
                               );
        }
      }

      if(empty($dataabsensi))
      {
        $dataabsensi = array( 'Value' => 'Tidak ada data Mac Address');
      }

      //dd($buffer);
      //dd($dataabsensi['Value']);

      return view('datamac',[ 'mac'=>$dataabsensi['Value']]);
      //return redirect()->route('mesin.dataabsensi');
	}
}
