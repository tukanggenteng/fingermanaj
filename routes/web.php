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
Route::get('/tes', function () {
    return view('tesview');
});

Route::get('/pegawai/daftarpegawai_m', 'mesinFinger@cekdatapegawai_finger')->name('mesin.datapegawai'); //daftar pegawai
Route::get('/absensi/daftarabsensi_m', 'mesinFinger@getSemuaKehadiran')->name('mesin.dataabsensi'); //daftar semua absensi

Route::get('/pegawai/jumlahfingerpegawai_m/{id}/{nama}', 'mesinFinger@datafinger_p')->name('mesin.datafingerpegawai');
Route::get('/pegawai/fingerpegawai_m_v/{id}/{nama}/{jari}', 'mesinFinger@cekdatafinger_p_v')->name('mesin.datafinger_v'); //untuk edit finger
Route::get('/pegawai/fingerpegawai_m_vt/{id}/{nama}/{jari}', 'mesinFinger@cekdatafinger_p_vt')->name('mesin.datafinger_vt'); //untuk tambah finger
//post atau update kefinger dengan metode set
//tidak berbeda antara menambahkan baru dan update, hanya beda isi data saja
Route::post('/pegawai/fingerpegawai_m', 'mesinFinger@setDataFinger')->name('mesin.datafinger_p');
//menghapus data sidik jari
Route::post('/pegawai/fingerpegawai_d', 'mesinFinger@hapusDataFinger')->name('mesin.datafinger_d');

Route::get('/pegawai/fingerpegawai_m/{id}/{jari}', 'mesinFinger@cekdatafinger_p')->name('mesin.datafinger');

Route::get('/cekmac', 'mesinFinger@checkMac')->name('mesin.mac');
Route::get('/tambahpegawai', 'mesinFinger@tambahNamaPegawai')->name('mesin.tambah');
Route::get('/hapuspegawai', 'mesinFinger@hapusNamaPegawai')->name('mesin.hapus');

Route::get('/tesfungsi', 'testing@tesFungsi')->name('tes.fungsi');
