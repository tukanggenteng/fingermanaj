<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ping;
use App\Http\Controllers\Controller;

class mesinFinger extends Controller
{

    //configurasi koneksi mesin, nanti bisa dipindahkan ke database
    public $ip = '10.10.10.10';
	  //public $ip = '192.168.0.80';
    public $key = 0;

    //format pemanggilan data pada mesin finger menggunakan metode SOAP

    //fungsi mengambil data (GET)
    // untuk mendapatkan semua (all) data user
    public function GetAllUserInfo()
    {
        $GetAllUserInfo    = '<GetAllUserInfo>
                                <ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey>
                              </GetAllUserInfo>';
        return $GetAllUserInfo;
    }
    // untuk mendapatkan satu (tunggal) data user
    public function GetUserInfo($PIN)
    {
      $GetUserInfo       = '<GetUserInfo>
                              <ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey>
                              <Arg>
                                <PIN Xsi:type=\"xsd:integer\">'.$PIN.'</PIN>
                              </Arg>
                            </GetUserInfo>';
      return $GetUserInfo;
    }

    //get log pegwai tertentu
    public function GetAttLog($PIN)
    {
        $GetAttLog         = '<GetAttLog>
                                <ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey>
                                <Arg>
                                  <PIN xsi:type=\"xsd:integer\">'.$PIN.'</PIN>
                                </Arg>
                              </GetAttLog>';
        return $GetAttLog;
    }
    //get log semua pegawai
    public function GetAttLogAll()
    {
        $GetAttLog         = '<GetAttLog>
                                <ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey>
                                <Arg>
                                  <PIN xsi:type=\"xsd:integer\">ALL</PIN>
                                </Arg>
                              </GetAttLog>';
        return $GetAttLog;
    }
    public function GetUserTemplate($PIN, $finger)
    {
      $GetUserTemplate   = '<GetUserTemplate>
                              <ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey>
                              <Arg>
                                <PIN xsi:type=\"xsd:integer\">'.$PIN.'</PIN>
                                <FingerID xsi:type=\"xsd:integer\">'.$finger.'</FingerID>
                              </Arg>
                            </GetUserTemplate>';
      return $GetUserTemplate;
    }

    public function GetOption($nama)
    {
      $GetOption         = '<GetOption>
                                    <ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey>
                                    <Arg>
                                      <Name xsi:type=\"xsd:string\">'.$nama.'</Name>
                                    </Arg>
                                  </GetOption>';
      return $GetOption;
    }

    //fungsi set data
    public function SetUserTemplate($PIN, $FingerID, $size, $valid, $template)
    {
        $SetUserTemplate   = '<SetUserTemplate>
                                    <ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey>
                                    <Arg>
                                      <PIN xsi:type=\"xsd:integer\">'.$PIN.'</PIN>
                                      <FingerID xsi:type=\"xsd:integer\">'.$FingerID.'</FingerID>
                                      <Size>'.$size.'</Size>
                                      <Valid>'.$valid.'</Valid>
                                      <Template>'.$template.'</Template>
                                    </Arg>
                                  </SetUserTemplate>';
        return $SetUserTemplate;
    }
    public function SetUserInfoPass($nama, $password, $PIN2)
    {
      $SetUserInfoPass   = '<SetUserInfo>
                              <ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey>
                              <Arg>
                                <PIN></PIN>
                                <Name>'.$nama.'</Name>
                                <Password>'.$password.'</Password>
                                <Group>1</Group>
                                <Privilege></Privilege>
                                <Card></Card>
                                <PIN2>'.$PIN2.'</PIN2>
                                <TZ1></TZ1>
                                <TZ2></TZ2>
                                <TZ3></TZ3>
                              </Arg>
                            </SetUserInfo>';
      return $SetUserInfoPass;
    }

    public function SetUserInfoTem($nama, $PIN2)
    {
      $SetUserInfoTem    = '<SetUserInfo>
                              <ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey>
                              <Arg>
                                <PIN></PIN>
                                <Name>'.$nama.'</Name>
                                <Password></Password>
                                <Group>1</Group>
                                <Privilege></Privilege>
                                <Card></Card>
                                <PIN2>'.$PIN2.'</PIN2>
                                <TZ1></TZ1>
                                <TZ2></TZ2>
                                <TZ3></TZ3>
                              </Arg>
                            </SetUserInfo>';
      return $SetUserInfoTem;
    }
    public function DeleteUser($PIN)
    {
      $DeleteUser        = '<DeleteUser>
                              <ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey>
                              <Arg>
                                <PIN Xsi:type=\"xsd:integer\">'.$PIN.'</PIN>
                              </Arg>
                            </DeleteUser>';
      return $DeleteUser;
    }

    public function ClearData($value)
    {
        $ClearData         = '<ClearData>
                                    <ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey>
                                    <Arg>
                                      <Value xsi:type=\"xsd:integer\">'.$value.'</Value>
                                    </Arg>
                                  </ClearData>';
        return $ClearData;
    }

    public function DeleteTemplate($PIN)
    {
      $DeleteTemplate    = '<DeleteTemplate>
                                    <ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey>
                                    <Arg>
                                      <PIN xsi:type=\"xsd:integer\">'.$PIN.'</PIN>
                                    </Arg>
                                  </DeleteTemplate>';
      return $DeleteTemplate;
    }
    public function SetAdminUserTem($nama, $PIN)
    {
      $SetAdminUserTem   = '<SetUserInfo>
                                    <ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey>
                                    <Arg>
                                      <PIN></PIN>
                                      <Name>'.$nama.'</Name>
                                      <Password></Password>
                                      <Group></Group>
                                      <Privilege>14</Privilege>
                                      <Card></Card>
                                      <PIN2>'.$PIN.'</PIN2>
                                      <TZ1></TZ1>
                                      <TZ2></TZ2>
                                      <TZ3></TZ3>
                                    </Arg>
                                  </SetUserInfo>';
      return $SetAdminUserTem;
    }

    public function SetAdminUserPass($nama, $password, $PIN2)
    {
      $SetAdminUserPass  = '<SetUserInfo>
                                    <ArgComKey Xsi:type=\"xsd:integer\">0</ArgComKey>
                                    <Arg>
                                      <PIN></PIN>
                                      <Name>'.$nama.'</Name>
                                      <Password>'.$password.'</Password>
                                      <Group></Group>
                                      <Privilege>14</Privilege>
                                      <Card></Card>
                                      <PIN2>'.$PIN2.'</PIN2>
                                      <TZ1></TZ1>
                                      <TZ2></TZ2>
                                      <TZ3></TZ3>
                                    </Arg>
                                  </SetUserInfo>';
      return $SetUserInfoPass;
    }
    public function ClearUserPassword($PIN)
    {
      $ClearUserPassword = '<ClearUserPassword>
                                      <ArgComKey xsi:type="xsd:integer">0</ArgComKey>
                                      <Arg>
                                        <PIN xsi:type="xsd:integer">'.$PIN.'</PIN>
                                      </Arg>
                                    </ClearUserPassword>';
      return $ClearUserPassword;

    }
    //---------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    public function apiMesin()
    {

    }

    //---------------------------------------------------------------------------------------------------------------------------------
    //menarik data pegawai di alat finger dan disimpan dalam array //!object
    public function cekdatapegawai_finger()
    {

      $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);

      $soap_request= $this->GetAllUserInfo();
      $buffer="";
      $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefiniskan sebagai variable agar menyimpan data

      //----untuk cek data dilakukan setelah pengambilan data pada variabel $buffer
      // dd($buffer);

      //  <GetAllUserInfoResponse>
      //  <Row><PIN>1</PIN><Name>FATHUL JENNAH</Name><Password></Password><Group>1</Group><Privilege>0</Privilege><Card>0</Card><PIN2>31</PIN2><TZ1>0</TZ1><TZ2>0</TZ2><TZ3>0</TZ3></Row> ◀
      //  <Row><PIN>2</PIN><Name>SATYAWIRAWAN</Name><Password></Password><Group>0</Group><Privilege>14</Privilege><Card>0</Card><PIN2>7239</PIN2><TZ1>0</TZ1><TZ2>0</TZ2><TZ3>0</TZ3></Row> ◀
      //  <Row><PIN>3</PIN><Name>SUNARTI</Name><Password></Password><Group>1</Group><Privilege>0</Privilege><Card>0</Card><PIN2>34</PIN2><TZ1>0</TZ1><TZ2>0</TZ2><TZ3>0</TZ3></Row> ◀
      //  <Row><PIN>4</PIN><Name>HAIS SUPIANI</Name><Password></Password><Group>1</Group><Privilege>0</Privilege><Card>0</Card><PIN2>38</PIN2><TZ1>0</TZ1><TZ2>0</TZ2><TZ3>0</TZ3></Row> ◀
      //  <Row><PIN>5</PIN><Name>SURATIN</Name><Password></Password><Group>1</Group><Privilege>0</Privilege><Card>0</Card><PIN2>51</PIN2><TZ1>0</TZ1><TZ2>0</TZ2><TZ3>0</TZ3></Row> ◀
      //  </GetAllUserInfoResponse>
      //  """

      //parsing data
      $buffer= $this->Parse_Data($buffer,"<GetAllUserInfoResponse>","</GetAllUserInfoResponse>");
      $buffer=explode("\r\n",$buffer);

      $datapegawai = array();
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
      //dd($datapegawai[1]['PIN']);

      return $datapegawai;
    }
    //END.------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------------------------------
    public function cekdatafinger_p($id,$jari) //id nanti diambil dari variable yang dilempar oleh fungsi data pegawai
    {
      // untuk sementara, ID pakai manual variabel untuk ujicoba
      //$id = 7239;
      $datafinger = array();

      $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);

      $soap_request= $this->GetUserTemplate($id, $jari);
      $buffer="";
      $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefiniskan sebagai variable agar menyimpan data

    //  <GetUserTemplateResponse>
    //  <Row><PIN>7239</PIN><FingerID>1</FingerID><Size>1494</Size><Valid>1</Valid><Template>TJVTUzIxAAAF1txx</Template></Row> ◀
    //  </GetUserTemplateResponse>

      //parsing data
      $buffer= $this->Parse_Data($buffer,"<GetUserTemplateResponse>","</GetUserTemplateResponse>");
      $buffer=explode("\r\n",$buffer);
      for($i=0;$i<count($buffer);$i++)
      {
        $data = $this->Parse_Data($buffer[$i],"<Row>","</Row>");
        if($this->Parse_Data($data,"<PIN>","</PIN>")!="")
        {
          $datafinger = array(
                                'PIN' => $this->Parse_Data($data,"<PIN>","</PIN>"),
                                'FingerID' => $this->Parse_Data($data,"<FingerID>","</FingerID>"),
                                'Size' => $this->Parse_Data($data,"<Size>","</Size>"),
                                'Valid' => $this->Parse_Data($data,"<Valid>","</Valid>"),
                                'Template' => $this->Parse_Data($data,"<Template>","</Template>"),
                               );
        }
      }

      if(empty($datafinger))
      {
        $datafinger = array( 'PIN' => '', 'FingerID' => $jari, 'Size' => '', 'Valid' => '', 'Template' => '', );
      }

      //return view('datapegawai_m',[ 'datapegawai' => $datapegawai ]);
      return $datafinger;
    }
    //END.------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    //menampilkan data log keseluruhan
    public function getSemuaKehadiran()
    {
      //dd($template);
      $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);

      $soap_request= $this->GetAttLogAll();
      $buffer="";
      $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefiniskan sebagai variable agar menyimpan data

      //Response data
      $buffer= $this->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
      $buffer=explode("\r\n",$buffer);

      $dataabsensi = array();

      for($i=0;$i<count($buffer);$i++)
      {
        $data = $this->Parse_Data($buffer[$i],"<Row>","</Row>");
        if($this->Parse_Data($data,"<PIN>","</PIN>")!="")
        {
          $dataabsensi[$i] = array(
                                'PIN' => $this->Parse_Data($data,"<PIN>","</PIN>"),
                                'DateTime' => $this->Parse_Data($data,"<DateTime>","</DateTime>"),
                                'Verified' => $this->Parse_Data($data,"<Verified>","</Verified>"),
                                'Status' => $this->Parse_Data($data,"<Status>","</Status>"),
                                'WorkCode' => $this->Parse_Data($data,"<WorkCode>","</WorkCode>"),
                               );
        }
      }

      if(empty($dataabsensi))
      {
        $dataabsensi[1] = array( 'PIN' => '', 'DateTime' => '', 'Verified' => '', 'Status' => '', 'WorkCode' => '', );
      }

      //dd($buffer);
      //dd($dataabsensi);

      return $dataabsensi;
    }
    //END.------------------------------------------------------------------------------------------------------------------------------
    //menampilkan data log 1 pegawai
    public function getKehadiranP($id)
    {
      $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);

      $soap_request= $this->GetAttLog($id);
      $buffer="";
      $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefiniskan sebagai variable agar menyimpan data

      //Response data
      $buffer= $this->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
      $buffer=explode("\r\n",$buffer);

      $dataabsensi = array();

      for($i=0;$i<count($buffer);$i++)
      {
        $data = $this->Parse_Data($buffer[$i],"<Row>","</Row>");
        if($this->Parse_Data($data,"<PIN>","</PIN>")!="")
        {
          $dataabsensi[$i] = array(
                                'PIN' => $this->Parse_Data($data,"<PIN>","</PIN>"),
                                'DateTime' => $this->Parse_Data($data,"<DateTime>","</DateTime>"),
                                'Verified' => $this->Parse_Data($data,"<Verified>","</Verified>"),
                                'Status' => $this->Parse_Data($data,"<Status>","</Status>"),
                                'WorkCode' => $this->Parse_Data($data,"<WorkCode>","</WorkCode>"),
                               );
        }
      }

      if(empty($dataabsensi))
      {
        $dataabsensi[1] = array( 'PIN' => '', 'DateTime' => '', 'Verified' => '', 'Status' => '', 'WorkCode' => '', );
      }

      return $dataabsensi;
    }
    //END.------------------------------------------------------------------------------------------------------------------------------



    //---------------------------------set data---------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------------------------------
    //Set Data FingerPrint
    public function setDataFinger(Request $request)
    {

      //dd($request);
      $status_store = $request->status_store;
      $PIN = $request->ID;
      $nama = $request->nama;
      $FingerID = $request->FingerID;
      $size = strlen($request->template_finger);
      $template = $request->template_finger;

      //dd($template);
      $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);

      $soap_request= $this->SetUserTemplate($PIN, $FingerID, $size, 1, $template);
      $buffer="";
      $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefiniskan sebagai variable agar menyimpan data

      //$buffer= $this->Parse_Data($buffer,"<SetUserTemplateResponse>","</SetUserTemplateResponse>");
      //$buffer= $this->Parse_Data($buffer,"<Information>","</Information>");
      //dd($buffer);

      $Response = $buffer; //response yang dibalikkan ke viewerblade

      //Refresh DB
    	$Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);
    	$soap_request="<RefreshDB><ArgComKey xsi:type=\"xsd:integer\">".$this->key."</ArgComKey></RefreshDB>";
    	$newLine="\r\n";
    	fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
      fputs($Connect, "Content-Type: text/xml".$newLine);
      fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
      fputs($Connect, $soap_request.$newLine);

      sleep(2);

      //End.RefreshDB--------------------------------

      //melempar ke route hasil update atau tambah
      //if( $request->status_store == "Tambah") { $route = 'mesin.datafinger_vt'; }
      //else{ $route = 'mesin.datafinger_v'; }

      //tapi berhubung langsung ada data, langsung ke view eedit saja

      return redirect()->route('mesin.datafinger_v',[$PIN, $nama, $FingerID])->with('message', '<strong>Data Fingerprint</strong> berhasil di'.$request->status_store.'!');
      //return redirect()->route('adm_user.index')->with('message', '<strong>'.$request->nama.'</strong> berhasil ditambahkan!');
    }
    //END.------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------------------------------
    // Tambah Data Pegawwai ke mesin Fingerprint
	public function tambahNamaPegawai(Request $request)
	{

		//dd($template);
      $PIN = $request->pin;
      $nama = $request->nama;
      if($nama=='' || $PIN =='') {
        $seluruh['status']="0";
        $seluruh['pesan']='Tidak boleh ada data yang kosong!';
        return $seluruh;
      }
      else
      {
        $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);

        $soap_request= $this->SetUserInfoPass(str_replace("'"," ",$nama), "", $PIN);
        $buffer="";
        $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefiniskan sebagai variable agar menyimpan data

        $buffer= $this->Parse_Data($buffer,"<SetUserInfoResponse>","</SetUserInfoResponse>");
        $buffer= $this->Parse_Data($buffer,"<Information>","</Information>");
        //dd($buffer);

        $Response = $buffer; //response yang dibalikkan ke viewerblade

        //Refresh DB---------------------------------------------
        $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);
        $soap_request="<RefreshDB><ArgComKey xsi:type=\"xsd:integer\">".$this->key."</ArgComKey></RefreshDB>";
        $newLine="\r\n";
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);

        sleep(2);

        //End.RefreshDB--------------------------------
        $seluruh['status']="1";
        $seluruh['nama']=$nama;
        return $seluruh;
      }

	}

    //---------------------------------------------------------------------------------------------------------------------------------
    // Delete Data Fingerprint
    public function hapusDataFinger(Request $request)
    {

      //dd($request);
      //$status_store = $request->status_store;
      $PIN = $request->ID;
      $nama = $request->nama;



      //dd($template);
      $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);

      $soap_request= $this->DeleteTemplate($PIN);
      $buffer="";
      $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefiniskan sebagai variable agar menyimpan data

      $buffer= $this->Parse_Data($buffer,"<DeleteTemplateResponse>","</DeleteTemplateResponse>");
      $buffer= $this->Parse_Data($buffer,"<Information>","</Information>");
      //dd($buffer);

      $Response = $buffer; //response yang dibalikkan ke viewerblade

      //Refresh DB---------------------------------------------
    	$Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);
    	$soap_request="<RefreshDB><ArgComKey xsi:type=\"xsd:integer\">".$this->key."</ArgComKey></RefreshDB>";
    	$newLine="\r\n";
    	fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
      fputs($Connect, "Content-Type: text/xml".$newLine);
      fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
      fputs($Connect, $soap_request.$newLine);

      //End.RefreshDB--------------------------------

      return redirect()->route('mesin.datafingerpegawai',[$PIN, $nama])->with('warning', '<strong>Data Fingerprint</strong> berhasil di'.$request->status_store.'!');
      //return redirect()->route('adm_user.index')->with('message', '<strong>'.$request->nama.'</strong> berhasil ditambahkan!');
    }
    //END.------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------------------------------
  	// Delete Data Pegawai
    public function hapusNamaPegawai(Request $request)
    {

      //dd($request);
      //$status_store = $request->status_store;
      $PIN = $request->id;
      $nama = $request->nama;

      //dd($template);
      $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);

      $soap_request= $this->DeleteUser($PIN);
      $buffer="";
      $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefinisikan sebagai variable agar menyimpan data

      $buffer= $this->Parse_Data($buffer,"<DeleteUserResponse>","</DeleteUserResponse>");
      $buffer= $this->Parse_Data($buffer,"<Information>","</Information>");
      //dd($buffer);

      $Response = $buffer; //response yang dibalikkan ke viewerblade

      //Refresh DB---------------------------------------------
    	$Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);
    	$soap_request="<RefreshDB><ArgComKey xsi:type=\"xsd:integer\">".$this->key."</ArgComKey></RefreshDB>";
    	$newLine="\r\n";
    	fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
      fputs($Connect, "Content-Type: text/xml".$newLine);
      fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
      fputs($Connect, $soap_request.$newLine);

      //End.RefreshDB--------------------------------

      //return redirect()->route('mesin.datapegawai')->with('warning', '<strong>Data '.$nama.'</strong> berhasil dihapus!');
      //return redirect()->route('adm_user.index')->with('message', '<strong>'.$request->nama.'</strong> berhasil ditambahkan!');
      $seluruh['status']="1";
      $seluruh['nama']=$nama;
      return $seluruh;
    }
    //END.------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------------------------------
  	// Wipe Data di mesin finger
    public function wipeData()
    {
      //dd($template);
      $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);

      $soap_request= $this->ClearData(1);
      $buffer="";
      $buffer = $this->SoapConnect($Connect, $soap_request, $buffer); //harus didefinisikan sebagai variable agar menyimpan data

      $buffer= $this->Parse_Data($buffer,"<ClearDataResponse>","</ClearDataResponse>");
      $buffer= $this->Parse_Data($buffer,"<Information>","</Information>");
      //dd($buffer);

      $Response = $buffer; //response yang dibalikkan ke viewerblade

      //Refresh DB---------------------------------------------
      $Connect = fsockopen($this->ip, "80", $errno, $errstr, 1);
      $soap_request="<RefreshDB><ArgComKey xsi:type=\"xsd:integer\">".$this->key."</ArgComKey></RefreshDB>";
      $newLine="\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
      fputs($Connect, "Content-Type: text/xml".$newLine);
      fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
      fputs($Connect, $soap_request.$newLine);

      //End.RefreshDB--------------------------------

      $seluruh['status']="1";
      return $seluruh;
    }
    //END.------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    //parsing data
    public function Parse_Data($data,$p1,$p2){
    	$data=" ".$data;
      //dd($data);
    	$hasil="";
    	$awal=strpos($data,$p1);
      //dd($awal);
    	if($awal!=""){
    		$akhir=strpos(strstr($data,$p1),$p2);
    		if($akhir!=""){
    			$hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
    		}
    	}
    	return $hasil;
    }
    //END.------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    // inisiasi untuk menarik data
    public function SoapConnect($Connect, $soap_request, $buffer)
    {
      if($Connect){

        $newLine="\r\n";
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);

        while($Response=fgets($Connect, 2048)){
          //dd($Response);
          $buffer=$buffer.$Response;
        }

      }
      else { echo "Koneksi Gagal";}
      //harus dikembalikan
      return $buffer;
    }
    //END.------------------------------------------------------------------------------------------------------------------------------

		//---------------------------------------------------------------------------------------------------------------------------------
    // Cek Kondisi Koneksi dengan ping
    public function connHealthCheck($url)
    {
			$health = Ping::check($url);

					if($health == 200) { $kondconn = 'alive'; }
					else { $kondconn = 'dead'; }
					return $kondconn;
    }
    //END.------------------------------------------------------------------------------------------------------------------------------

}
