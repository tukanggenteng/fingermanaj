<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//DB
use App\ServerAccs;
use App\Sidikjaris;

class testing extends mesinFinger
{
    public function tesFungsiGet()
    {
        $mesin = new mesinFinger;
        $url = session('set_ip');
        $datapegawai = array();

        $Connect = fsockopen($url, "80", $errno, $errstr, 1);

        $soap_request= $mesin->GetUserInfo(6588);
        $buffer="";
        $buffer = $this->SoapConnect($Connect, $soap_request, $buffer);

        dd($buffer);

        //parsing data
        $buffer= $this->Parse_Data($buffer,"<GetUserInfoResponse>","</GetUserInfoResponse>");
        $buffer=explode("\r\n",$buffer);

        for($i=0;$i<count($buffer);$i++)
        {
          $data = $this->Parse_Data($buffer[$i],"<Row>","</Row>");
          if($this->Parse_Data($data,"<PIN>","</PIN>")!='')
          {
            $datapegawai[$i] = array(
                                  'PIN' => $this->Parse_Data($data,"<PIN>","</PIN>"),
                                  'Name' => $this->Parse_Data($data,"<Name>","</Name>"),
                                  'Password' => $this->Parse_Data($data,"<Password>","</Password>"),
                                  'Group' => $this->Parse_Data($data,"<Group>","</Group>"),
                                  'Privilege' => $this->Parse_Data($data,"<Privilege>","</Privilege>"),
                                  'Card' => $this->Parse_Data($data,"<Card>","</Card>"),
                                  'PIN2' => $this->Parse_Data($data,"<PIN2>","</PIN2>"),
                                 );
          }
        }

        dd($datapegawai);
    }

    public function tesFungsiPost()
    {
        $mesin = new mesinFinger;
        $url = session('set_ip');
        $datapegawai = array();

        $Connect = fsockopen($url, "80", $errno, $errstr, 1);

        //-------------------ganti fungsi untuk testing
        //$soap_request= $mesin->SetUserInfoPass("", 11111111, 46);
        $soap_request= $mesin->ClearUserPassword(6588);
        //-----------------------------------------

        $buffer="";
        $buffer = $this->SoapConnect($Connect, $soap_request, $buffer);

        dd($buffer);

        //parsing data
        $buffer= $this->Parse_Data($buffer,"<GetUserInfoResponse>","</GetUserInfoResponse>");
        $buffer=explode("\r\n",$buffer);

        for($i=0;$i<count($buffer);$i++)
        {
          $data = $this->Parse_Data($buffer[$i],"<Row>","</Row>");
          if($this->Parse_Data($data,"<PIN>","</PIN>")!='')
          {
            $datapegawai[$i] = array(
                                  'PIN' => $this->Parse_Data($data,"<PIN>","</PIN>"),
                                  'Name' => $this->Parse_Data($data,"<Name>","</Name>"),
                                  'Password' => $this->Parse_Data($data,"<Password>","</Password>"),
                                  'Group' => $this->Parse_Data($data,"<Group>","</Group>"),
                                  'Privilege' => $this->Parse_Data($data,"<Privilege>","</Privilege>"),
                                  'Card' => $this->Parse_Data($data,"<Card>","</Card>"),
                                  'PIN2' => $this->Parse_Data($data,"<PIN2>","</PIN2>"),
                                 );
          }
        }

        dd($datapegawai);
    }

    public function tesFungsiFungsi(Request $request)
    {
      $request->iddarimesin = 10540;
      $request->iddarieabsen = 10540;
      $request->nama = '';

      $store = $this->store($request);
      dd($store);
      //return $response;



    }

    public function tesFungsi2()
    {
      $mesin = new mesinFinger;
      //$data = $mesin->cekdatapegawai_tunggal(1200);
      //$data = $mesin->getKehadiranP(7239);
      //$data = $mesin->getSemuaKehadiran();
      //$data = $mesin->cekdatafinger_p(1200, 0);
      //$data = $this->cekdataPinFp(2536);
      //dd($data);
      //return $data;

      $data = $this->tesUDP();
      dd($data);
    }

    public function tesPost()
    {
      return view('tesview');
    }

    /*
    testing di bawah ini... fungsi  bisa dihapus semuanya jika sudah digunakan
    */
    //code here
    public function store(Request $request)
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
          $status = "1";
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
    //


    public function tesUDP()
    {
      $url = session('set_ip'); //get data ip dari var session
      $kon = $this->connHealthCheck($url);

      if($kon=='dead')
      {
          $seluruh['status']="0";
          return $seluruh; //data dibiarkan tanpa terisi
      }
      else
      {
          $Connect = fsockopen("10.10.10.10", "80", $errno, $errstr, 1);

          /*
          opsi 1 del all log information
          opsi 2 del all fingerprint template
          opsi 3 del all user information
          */
          /* yang lama
          opsi 1 del all user information
          opsi 2 del all fingerprint template
          opsi 3 del all user information
          */
          $soap_request= $this->GetAllUserInfo();
          $buffer="";
          $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefinisikan sebagai variable agar menyimpan data

          dd($buffer);

          $buffer= $this->Parse_Data($buffer,"<ClearDataResponse>","</ClearDataResponse>");
          $buffer= $this->Parse_Data($buffer,"<Information>","</Information>");
          //dd($buffer);

          $Response = $buffer; //response yang dibalikkan ke viewerblade

          //Refresh DB---------------------------------------------
          $this->RefreshDB($url);
          //End.RefreshDB--------------------------------

          $seluruh['status']="1";
          return $seluruh;
        }
      }
}
