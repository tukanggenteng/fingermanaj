<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//untu coba-coba
Route::get('/tesfungsiG', 'testing@tesFungsiGet')->name('tes.fungsiG');
Route::get('/tesfungsiP', 'testing@tesFungsiPost')->name('tes.fungsiP');
Route::get('/tesfungsiF', 'testing@tesFungsiFungsi')->name('tes.fungsiF');
Route::get('/tesfungsi', 'testing@tesFungsi2')->name('tes.fungsiF');
//----------------------------------------------------


Route::get('/pegawai/dtdatapegawai_m', 'tampilData@datapegawai_finger')->name('dt.datapegawai'); //daftar pegawai
Route::get('/pegawai/daftarpegawai_m', 'tampilData@datapegawai_finger_view')->name('mesin.datapegawai'); //daftar pegawai
//Route::get('/pegawaites', 'mesinFinger@datapegawai_finger'); //untuk tes daftar pegawai, ubah fungsi yang digunakan setelah @
Route::get('/absensi/dtdaftarabsensi', 'tampilData@dtSemuaKehadiran')->name('mesin.dataabsensi'); //datatable semua absensi
Route::get('/absensi/daftarabsensi_m', 'tampilData@getSemuaKehadiran_v')->name('mesin.dataabsensi'); //daftar semua absensi
Route::get('/absensi/dtdaftarabsensi_p/{id}', 'tampilData@dtKehadiran_p')->name('mesin.dataabsensi'); //datatable absensi 1 pegawai
Route::get('/absensi/daftarabsensi_mp/{id}/{nama}', 'tampilData@getKehadiran_vp')->name('mesin.dataabsensi'); //daftar absensi 1 pegawai


Route::post('/pegawai/tambahpegawai', 'mesinFinger@tambahNamaPegawai')->name('mesin.tambahpegawai'); //tambah data pegawai ke finger
Route::post('/pegawai/hapuspegawai', 'mesinFinger@hapusNamaPegawai')->name('mesin.hapuspegawai'); //hapus data pegawai di finger
Route::post('/wipedata', 'mesinFinger@wipeData')->name('mesin.wipedata'); //wipe data di finger

Route::get('/pegawai/jumlahfingerpegawai_m/{id}/{nama}', 'tampilData@datafinger_p')->name('mesin.datafingerpegawai'); //cek data finger view
Route::get('/pegawai/fingerpegawai_m_v/{id}/{nama}/{jari}', 'tampilData@cekdatafinger_p_v')->name('mesin.datafinger_v'); //untuk edit finger
Route::get('/pegawai/fingerpegawai_m_vt/{id}/{nama}/{jari}', 'tampilData@cekdatafinger_p_vt')->name('mesin.datafinger_vt'); //untuk tambah finger
Route::get('/pegawai/pinpegawai_m_v/{id}', 'tampilData@cekdatapin_p_v')->name('mesin.datapin_v'); //untuk edit PIN/Password
//post atau update kefinger dengan metode set
//tidak berbeda antara menambahkan baru dan update, hanya beda isi data saja
Route::post('/pegawai/fingerpegawai_m', 'mesinFinger@setDataFinger')->name('mesin.datafinger_p');
Route::post('/pegawai/setpinpegawai', 'tampilData@setDataPin')->name('mesin.setdatapin_p');
//menghapus data sidik jari
Route::post('/pegawai/fingerpegawai_d', 'mesinFinger@hapusDataFinger')->name('mesin.datafinger_d');
//----------------------
Route::get('/pegawai/fingerpegawai_m/{id}/{jari}', 'mesinFinger@cekdatafinger_p')->name('mesin.datafinger'); //cek data finger per id jari
//----------------------------
Route::get('/cekmac', 'tampilData@checkMac')->name('mesin.mac');
//konfigurasi
Route::get('/konfigurasi', 'tampilData@config')->name('mesin.konfig');
Route::post('/konfigurasi_set', 'tampilData@config_set')->name('mesin.konfig_set');
Route::get('/konfig/ip', 'tampilData@ip')->name('mesin.ip');
Route::get('/konfig/sv', 'tampilData@sv')->name('mesin.ip');
Route::get('/konfig/jlhpeg', 'tampilData@jlhpeg')->name('mesin.jlhpeg'); //data pegawai dalam json array
Route::post('/cekkon', 'mesinFinger@konping')->name('mesin.konping');


//fungsi eabsen
// -data table
Route::get('/cekpegawai_f_eabsen/{id}', 'eabsenController@dteabsen_dp_af')->name('eabsen.dp_af'); //sudah ada data fingerprint
Route::get('/cekpegawai_fb_eabsen/{id}', 'eabsenController@dteabsen_dp_tf')->name('eabsen.dp_tf'); //belum ada data fingerprint
//data untuk tambah ke finger
Route::get('/data_fb_eabsen/{id}', 'eabsenController@deabsen_dp_tf')->name('eabsen.d_tf'); //belum ada data fingerprint

Route::get('/eabsen/downloadpegawai', 'eabsenController@eabsen_dp')->name('eabsen.dp');
Route::get('/eabsen/uploadfinger', 'eabsenController@eabsen_uf')->name('eabsen.uf');
Route::get('/eabsen/downloadfinger', 'eabsenController@eabsen_df')->name('eabsen.df');
Route::get('/dtpinfp/{id}', 'tampilData@cekdataPinFp')->name('eabsen.dtpinfp'); //cek Ketersediaan PIN/Sidik Jari
//eksekusi download data finger ke mesin
Route::post('/eabsen/download_dfinger', 'eabsenController@deabsen_down_fp')->name('eabsen.d_df');
//Route::post('/eabsen/download_dfingerall', 'eabsenController@deabsen_down_fpAll')->name('eabsen.d_dfall');
//eksekusi upload data finger dari mesin
Route::post('/eabsen/upload_dfinger', 'eabsenController@deabsen_up_proses')->name('eabsen.u_df');
//Route::post('/eabsen/upload_dfingerall', 'eabsenController@deabsen_up_fpAll')->name('eabsen.u_dfall');

//eksekusi hapus data finger dari opsi eabsen
Route::post('/eabsen/hapus_dfinger', 'eabsenController@deabsen_del')->name('eabsen.h_df');
//END./Fungsi Eabsen

//Fungsi dari database
Route::get('/dtinstansi', 'db_instansi@dt_instansi')->name('db.dtinstansi');
Route::get('/instansi', 'db_instansi@data_instansi_v')->name('db.instansi');
Route::resource('/instansi_r', 'db_instansi');
Route::get('/instansi/cari','db_instansi@cari')->name('cariinstansi');
//Route::get('/testing','db_instansi@testing');
Route::resource('/alamatip', 'db_alamatip');

//url server
Route::post('/urlServer', 'urlaccess@store')->name('urlaccess.store');
Route::patch('/urlServer', 'urlaccess@update')->name('urlaccess.update');
Route::delete('/urlServer/{id}', 'urlaccess@destroy')->name('urlaccess.destroy');

//sidik jari
Route::get('/dtsidikjari', 'sidikjari@dtsidikjari')->name('db.dtsidikjari');
Route::resource('/sidikjari', 'sidikjari');
Route::post('/backupfp', 'sidikjari@backupfp')->name('db.backupfp');
