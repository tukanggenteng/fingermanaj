<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ping;
use App\Http\Controllers\Controller;

class tampilData extends mesinFinger
{
  //---------------------------------------------------------------------------------------------------------------------------------
  //memanggil data pegawai dari fungsi cekdatapegawai_finger() for datatable
  //object request digunakan pengecekan config set ip

  public function datapegawai_finger()
  {
      $mesin = new mesinFinger;
      return datatables()->of($mesin->cekdatapegawai_finger())->toJson();
      //dd($this->cekdatapegawai_finger());
  }
  //END.------------------------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------------------------
  //menampilkan data pegawai pada view
  public function datapegawai_finger_view()
  {
    //cek koneksi biar fungsi ----------------------------------------------------------------
    $mesin = new mesinFinger;
    $kon = $mesin->connHealthCheck(session('set_ip'));
    if($kon=='dead')
    {
       return redirect()->route('mesin.konfig')->with('pesan', 'Alat fingerprintscan tidak bisa dihubungi, silakan setting ulang alamat IP !');
    }
    // ./cek koneksi biar fungsi ----------------------------------------------------------------

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

  //---------------------------------------------------------------------------------------------------------------------------------
  //menampilkan data PIN/Password pegawai dari alat finger sekaligus melakukan edit
  public function cekdatapin_p_v($id) //id nanti diambil dari variable yang dilempar oleh fungsi data pegawai
  {
    $mesin = new mesinFinger;
    $datapin = array();
    $datapin = $mesin->cekdatapegawai_tunggal($id);
    dd($datapin);
    return view('datapinpegawai_m_v',[ 'ID'=>$id, 'datapin' => $datapin ]);
  }
  //END.------------------------------------------------------------------------------------------------------------------------------
  //Set Data Nama/PIN/Password
    public function setDataPin(Request $request) //untuk fungsi post biasa (tanpa fungsi ajax)
    {

      //dd($request);
      $status_store = $request->status_store;

      //Data
      $request->ID = $request->ID;
      $request->nama = $request->nama;
      $request->template_finger = $request->password;
      //----

      $mesin = new mesinFinger;
      $mesin->tambahNamaPegawai($request);

      //melempar ke route hasil update atau tambah
      //if( $request->status_store == "Tambah") { $route = 'mesin.datafinger_vt'; }
      //else{ $route = 'mesin.datafinger_v'; }

      //tapi berhubung langsung ada data, langsung ke view eedit saja

      return redirect()->route('mesin.datapin_v',[$request->ID])->with('message', '<strong>Data Pegawai</strong> berhasil di'.$request->status_store.'!');
    }
    //END.------------------------------------------------------------------------------------------------------------------------------



  //---------------------------------------------------------------------------------------------------------------------------------
  //memanggil data absensi dari fungsi cekdatapegawai_finger() for datatable
  public function dtSemuaKehadiran()
  {
      $mesin = new mesinFinger;
      $datapegawai = $mesin->cekdatapegawai_finger();
      $dataabsensi = $mesin->getSemuaKehadiran();

      $dataabsenbaru = array();

      for($i=1; $i<=count($dataabsensi);$i++)
      {
          if(!isset($datapegawai[1]['Name']))
          {
            $dataabsenbaru[$i] = array(
                  'no' => '',
                  'id' => '',
                  'nama' => '',
                  'tanggal' => '',
                  'jam' => '',
                  'keteranganabsen' => '',
                );
          }
          else
          {
              if(empty($dataabsensi[0]['PIN']))
              {
                $dataabsenbaru[$i] = array(
                      'no' => '',
                      'id' => '',
                      'nama' => '',
                      'tanggal' => '',
                      'jam' => '',
                      'keteranganabsen' => '',
                    );
              }
              else
              {
                  //menambahkan nama
                  for($j=1; $j<=count($datapegawai);$j++)
                  {
                      if($datapegawai[$j]['PIN2']==$dataabsensi[$i]['PIN']) { $nama = $datapegawai[$j]['Name']; }
                      else { $nama = '';  }
                  }

                  //menambah keterangan absen
                  $kta = $dataabsensi[$i]['Status'];
                  if     ($kta == '0') { $keteranganabsen = "Masuk"; }
                  else if($kta == '1') { $keteranganabsen = "Pulang"; }
                  else if($kta == '2') { $keteranganabsen = "Mulai Istirahat"; }
                  else if($kta == '3') { $keteranganabsen = "Selesai Istirahat"; }
                  else                 { $keteranganabsen = ""; }
                  //-----------------------

                  $jam = date("H:i:s", strtotime($dataabsensi[$i]['DateTime']));
                  $tanggal = date("D d/n/Y", strtotime($dataabsensi[$i]['DateTime']));
                  $dataabsenbaru[$i] = array(
                        'no' => $i,
                        'id' => $dataabsensi[$i]['PIN'],
                        'nama' => $nama,
                        'tanggal' => $tanggal,
                        'jam' => $jam,
                        'keteranganabsen' => $keteranganabsen,
                      );
              }
          }
      }

      return datatables()->of($dataabsenbaru)->toJson();
  }
  //END.------------------------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------------------------
  //menampilkan data absensi pada view
  public function getSemuaKehadiran_v()
  {
    //cek koneksi biar fungsi ----------------------------------------------------------------
    $mesin = new mesinFinger;
    $kon = $mesin->connHealthCheck(session('set_ip'));
    if($kon=='dead')
    {
       return redirect()->route('mesin.konfig')->with('pesan', 'Alat fingerprintscan tidak bisa dihubungi, silakan setting ulang alamat IP !');
    }
    // ./cek koneksi biar fungsi ----------------------------------------------------------------
    return view('dataabsensi_m');
  }
  //END.------------------------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------------------------
  //memanggil data absensi dari fungsi cekdatapegawai_finger() for datatable
  public function dtKehadiran_p($id)
  {
      $mesin = new mesinFinger;
      $dataabsensi = $mesin->getKehadiranP($id);

      $dataabsenbaru = array();

      for($i=1; $i<=count($dataabsensi);$i++)
      {

        if(empty($dataabsensi[0]['PIN']))
        {
          $dataabsenbaru[$i] = array(
                'no' => '',
                'id' => '',
                'nama' => '',
                'tanggal' => '',
                'jam' => '',
                'keteranganabsen' => '',
              );
        }
        else
        {
          //menambah keterangan absen
          $kta = $dataabsensi[$i]['Status'];
          if     ($kta == '0') { $keteranganabsen = "Masuk"; }
          else if($kta == '1') { $keteranganabsen = "Pulang"; }
          else if($kta == '2') { $keteranganabsen = "Mulai Istirahat"; }
          else if($kta == '3') { $keteranganabsen = "Selesai Istirahat"; }
          else                 { $keteranganabsen = ""; }
          //-----------------------

            $jam = date("H:i:s", strtotime($dataabsensi[$i]['DateTime']));
            $tanggal = date("D d/n/Y", strtotime($dataabsensi[$i]['DateTime']));
            $dataabsenbaru[$i] = array(
                  'no' => $i,
                  'tanggal' => $tanggal,
                  'jam' => $jam,
                  'keteranganabsen' => $keteranganabsen,
                );
        }
      }

      return datatables()->of($dataabsenbaru)->toJson();
  }
  //END.------------------------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------------------------
  //menampilkan data absensi pada view
  public function getKehadiran_vp($id, $nama)
  {
    return view('dataabsensi_mp',[ 'id' => $id, 'nama' => $nama ]);
  }
  //END.------------------------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------------------------
  //menampilkan halaman konfigurasi
  public function config()
  {

    $mesin = new mesinFinger;
    $url = session('set_ip'); //get data ip dari var session
    $mesin->kondConn($url);

    return view('konfigurasi', ['session_d' => $url]);
  }
  //END.------------------------------------------------------------------------------------------------------------------------------




  // fungsi konfigurasi
  function checkMac()
	{
		  //dd($template);
      $url = session('set_ip');
      $mesin = new mesinFinger;
      $Connect = fsockopen($url, "80", $errno, $errstr, 1);

	    //$nama = '~SerialNumber';
      $nama = 'MAC'; //opsi menggunakan data MAC Address
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
