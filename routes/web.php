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
Route::get('/tesfungsi', 'testing@tesPost')->name('tes.fungsi');

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

Route::get('/pegawai/jumlahfingerpegawai_m/{id}/{nama}', 'tampilData@datafinger_p')->name('mesin.datafingerpegawai');
Route::get('/pegawai/fingerpegawai_m_v/{id}/{nama}/{jari}', 'tampilData@cekdatafinger_p_v')->name('mesin.datafinger_v'); //untuk edit finger
Route::get('/pegawai/fingerpegawai_m_vt/{id}/{nama}/{jari}', 'tampilData@cekdatafinger_p_vt')->name('mesin.datafinger_vt'); //untuk tambah finger
//post atau update kefinger dengan metode set
//tidak berbeda antara menambahkan baru dan update, hanya beda isi data saja
Route::post('/pegawai/fingerpegawai_m', 'mesinFinger@setDataFinger')->name('mesin.datafinger_p');
//menghapus data sidik jari
Route::post('/pegawai/fingerpegawai_d', 'mesinFinger@hapusDataFinger')->name('mesin.datafinger_d');

Route::get('/pegawai/fingerpegawai_m/{id}/{jari}', 'mesinFinger@cekdatafinger_p')->name('mesin.datafinger');

Route::get('/cekmac', 'mesinFinger@checkMac')->name('mesin.mac');
//konfigurasi
Route::get('/konfigurasi', 'tampilData@config')->name('mesin.konfig');
Route::post('/konfigurasi_set', 'tampilData@config_set')->name('mesin.konfig_set');
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
