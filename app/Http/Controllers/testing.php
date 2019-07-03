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
      $data = $this->cekdataPinFp(2536);
      dd($data);
      return $data;
    }

    public function tesPost()
    {
      return view('tesview');
    }


    //testing... fungsi eaben, bisa dihapus semuanya
    public function cekdataPinFp($id)
    {
      $mesin = new mesinFinger;
      $datapinfp = $mesin->cekdatapegawai_tunggal($id);
      //$datapegawai = $mesin->cekdatapegawai_finger();
      //dd($datapinfp);

      $response = array();
      //cek data pegawai dulu, untuk mengetahui ada atau tidaknya data password,
      //jika tidak ada proses untuk upload data finger
      if(!empty($datapegawai['Password'])) //prosesPin
      {
          $jenis = 'Password/PIN';
          $status = "1";
      }
      else //prosesfp
      {
          //kemudian cek ketersedian data sidik jari pada mesin
          $fp = $mesin->cekdatafinger_p($id, 0);
          if(!empty($fp['Template']))
          {
            //eksekusi perintah upload
            $status = '1';
            $jenis = 'Sidik Jari';

          }
          else
          {
            $status = '0';
            $jenis = 'Tidak ada Data PIN dan Password pada mesin!';
          }
      }
      $response = array(
          'status' => $status, //data dari fungsi mesin
          'nama' => $datapinfp['Name'],
          'id' => $id,
          'jenis' => $jenis,
        );

      return $response;
    }
}
