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
