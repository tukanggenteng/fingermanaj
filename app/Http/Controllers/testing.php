<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $request->iddarimesin = 10229;
        $request->iddarieabsen = 10229;
        $request->nama = "Testing";
        //$response = array();
        $data = $this->deabsen_up_proses($request);
        //dd($data);



    }

    public function tesFungsi2()
    {
      $mesin = new mesinFinger;
      //$data = $mesin->cekdatapegawai_tunggal(1200);
      //$data = $mesin->getKehadiranP(7239);
      //$data = $mesin->getSemuaKehadiran();
      //$data = $mesin->cekdatafinger_p(1200, 0);
      $request->iddarimesin = 830;
      $data = $this->deabsen_up_fpAll($request);
      dd($data);
      return $data;
    }

    public function tesPost()
    {
      return view('tesview');
    }


    //testing... fungsi eaben, bisa dihapus semuanya
    public function deabsen_up_fpAll(Request $request)
    {
        $mesin = new mesinFinger;
        $datapegawai = $mesin->cekdatapegawai_finger();
        $jumlah_dp = count($datapegawai);
        $response= array();

        for($i=1;$i<=$jumlah_dp;$i++)
        {
          $request->iddarimesin = $datapegawai[$i]['PIN2'];
          $request->iddarieabsen = $datapegawai[$i]['PIN2'];
          $request->nama = $datapegawai[$i]['Name'];
          $up = $this->deabsen_up_proses($request);
          $response = $up;

        }
        dd($response);
        return $response;
    }
    public function deabsen_up_proses(Request $request)
    {
        $iddarimesin = $request->iddarimesin;
        $iddarieabsen = $request->iddarieabsen;
        $nama = $request->nama;
        $mesin = new mesinFinger;
        $datapegawai = $mesin->cekdatapegawai_tunggal($iddarimesin);
        //$datapegawai = $mesin->cekdatapegawai_finger();

        $response = array();
        //cek data pegawai dulu, untuk mengetahui ada atau tidaknya data password,
        //jika tidak ada proses untuk upload data finger
        if(empty($datapegawai['Password'])) //prosesfp
        {
            $request->ID = $iddarimesin;
            //$fp = $mesin->hapusDataFingerCore($request);
            //kemudian cek ketersedian data sidik jari pada mesin
            $fp = $mesin->cekdatafinger_p($iddarimesin, 0);
            //dd(!empty($fp['Template']));
            if(!empty($fp['Template']))
            {
              //eksekusi perintah upload
              $up_fp = $this->deabsen_up_fp($iddarimesin, $iddarieabsen);
              $status = '1';
              $jenis = 'Sidik Jari';
              $status_pesan = $up_fp;


            }
            else
            {
              $status = '0';
              $jenis = 'Tidak ada Data Finger';
              $status_pesan ='';
            }

        }
        else //prosesPin
        {
            $request->ID = $iddarimesin;
            $pin = $this->deabsen_up_passpin($iddarimesin, $iddarieabsen);

            $jenis = 'Password/PIN';
            $status = "1";
            $status_pesan = $pin;
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
    //get data pass/pin then upload
    public function deabsen_up_passpin($id_m, $id_ea)
    {
      $mesin = new mesinFinger;
      $datapegawai = $mesin->cekdatapegawai_tunggal($id_m);
      $upload = array();
      $password = str_replace($datapegawai['Name'],"",$datapegawai['Password']); //ALat Lama PIN pegawwai ditempeli Nama, Alat baru tidak

      for($i=0;$i<2;$i++)
      {
          $upload = array(
            'pegawai_id' => $id_ea,
            'size' => strlen($password),
            'valid' => 1,
            'templatefinger' => $password,
          );
          $kirim = $this->kontenKirim($upload);
          $upload_arr[]=$upload; //untuk info data hasil
          $upload_arr[]=array('status pesan' => $kirim, );

      }

      return $upload_arr;
    }
    //get data fingerprint then upload
    public function deabsen_up_fp($id_m, $id_ea)
    {
      $mesin = new mesinFinger;

      for($i=0;$i<2;$i++)
      {
          $fp = $mesin->cekdatafinger_p($id_m, $i);
          $upload = array(
            'pegawai_id' => $id_ea,
            'size' => $fp['Size'],
            'valid' => 1,
            'templatefinger' => $fp['Template'],
          );
          $kirim = $this->kontenKirim($upload);

          $upload_arr[]=$upload; //untuk info data hasil
          $upload_arr[]=array('status pesan' => $kirim, );
      }

      //dd($upload_arr);
      return $upload_arr;
    }

    public function kontenKirim($upload)
    {
      $curl = curl_init();
      $json = json_encode($upload);
  ;

      curl_setopt_array($curl, array(
      CURLOPT_URL => "http://eabsen.kalselprov.go.id/api/addfinger",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $json,
      CURLOPT_HTTPHEADER => array(
        "Accept: application/json",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Content-Type: application/json",
        "Host: eabsen.kalselprov.go.id",
        "Postman-Token: cced12c0-1a1d-4d8a-af14-11f310f1301c,adf3285b-a076-4ace-8b7f-02a083b8181a",
        "User-Agent: PostmanRuntime/7.15.0",
        "accept-encoding: gzip, deflate",
        "cache-control: no-cache",
      ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
      $response = "cURL Error #: ". $err;
      return $response;
      } else {
      return $response;
      }
    }
}
