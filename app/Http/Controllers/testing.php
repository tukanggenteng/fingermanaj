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
        $request->iddarimesin = 12808;
        $request->iddarieabsen = 1222;
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
            if(!empty($fp))
            {
              //eksekusi perintah upload
              $up_fp = $this->deabsen_up_fp($iddarimesin);
              $status = '1';
              $jenis = 'Sidik Jari';


            }
            else
            {
              $status = 'Tidak ada Data Finger';
              $jenis = 'Sidik Jari';
            }

        }
        else //prosesPin
        {
            $request->ID = $iddarimesin;
            $pin = $this->deabsen_up_passpin($iddarimesin);
            $jenis = 'Password/PIN';
            $status = "1";
        }


        $response = array(
            'status' => $status, //data dari fungsi mesin
            'nama' => $nama,
            'id' => $request->iddarimesin,
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
      $password = str_replace($datapegawai['Name'],"",$datapegawai['Password']); //ALat Lama PIN pegawwai ditempeli Nama, Alat baru tidak

      for($i=0;$i<2;$i++)
      {
          $upload = array(
            'pegawai_id' => $id,
            'size' => strlen($password),
            'valid' => 1,
            'templatefinger' => $password,
          );

          $upload_arr[]=$upload; //untuk info data hasil

      }

      $jenis = 'Password/PIN';
      $status = "1";

      return $upload_arr;
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
            'size' => $fp['Size'],
            'valid' => 1,
            'templatefinger' => $fp['Template'],
          );
          $this->kontenKirim($upload['pegawai_id'], $upload['size'], $upload['templatefinger']);

          $jenis = 'Sidik jari';
          $status = "1";

          $upload_arr[]=$upload; //untuk info data hasil
      }

      //dd($upload_arr);
      return $upload_arr;
    }

    public function kontenKirim($pegawai_id, $size, $templatefinger)
    {
        $request = new mesinFinger;
        $request->setUrl('http://eabsen.kalselprov.go.id/api/addfinger');
        $request->setMethod(HTTP_METH_POST);

        $request->setHeaders(array(
          'cache-control' => 'no-cache',
          'Connection' => 'keep-alive',
          'content-length' => '93',
          'accept-encoding' => 'gzip, deflate',
          'Host' => 'eabsen.kalselprov.go.id',
          'Postman-Token' => '48b40f45-557a-4309-929a-f18fc7e87d66,ed14ac60-233d-4c40-b804-43ee0810f43a',
          'Cache-Control' => 'no-cache',
          'User-Agent' => 'PostmanRuntime/7.15.0',
          'Accept' => 'application/json'
        ));

        $request->setBody('{
        	"pegawai_id" : "'.$pegawai_id.'",
            "size" : "'.$size.'",
            "valid" : 1,
        	"templatefinger" : "'.$templatefinger.'"
        }
        ');

        try {
          $response = $request->send();

          echo $response->getBody();
        } catch (HttpException $ex) {
          echo $ex;
        }
    }
}
