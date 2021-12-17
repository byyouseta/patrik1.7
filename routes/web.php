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
   return view('auth.login');
});

//Route::get('/clear-cache', function() {
//    Artisan::call('cache:clear');
//    return "Cache is cleared";
//});

// Route::get('/info/presensi', function () {
//    return view('presensi.info_presensi');
// });



Auth::routes(['register' => false]);
//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Password
Route::get('/password', 'PasswordController@index');
Route::post('/password/ganti', 'PasswordController@change');
//Pegawai
Route::get('/pegawai', 'PegawaiController@index');
Route::get('/pegawai/tambah', 'PegawaiController@tambah');
Route::post('/pegawai/tambahpegawai', 'PegawaiController@tambahpegawai');
Route::get('/pegawai/edit/{id}', 'PegawaiController@edit');
Route::post('/pegawai/update/{id}', 'PegawaiController@update');
Route::get('/pegawai/hapus/{id}', 'PegawaiController@delete');
Route::get('/pegawai/cari', 'PegawaiController@cari');
Route::post('/pegawai/import_excel', 'PegawaiController@import_excel');
//Unit
Route::get('/unit', 'UnitController@index');
Route::get('/unit/tambah', 'UnitController@tambah');
Route::post('/unit/tambahunit', 'UnitController@tambahunit');
Route::get('/unit/edit/{id}', 'UnitController@edit');
Route::put('/unit/update/{id}', 'UnitController@update');
Route::get('/unit/hapus/{id}', 'UnitController@delete');
Route::get('/unit/cari', 'UnitController@cari');
//Ruangan
Route::get('/ruangan', 'RuanganController@index');
Route::get('/ruangan/tambah', 'RuanganController@tambah');
Route::post('/ruangan/tambahruangan', 'RuanganController@tambahruangan');
Route::get('/ruangan/edit/{id}', 'RuanganController@edit');
Route::put('/ruangan/update/{id}', 'RuanganController@update');
Route::get('/ruangan/hapus/{id}', 'RuanganController@delete');
//Agenda
Route::get('/agenda', 'AgendaController@index');
Route::get('/agenda/tambah', 'AgendaController@tambah');
Route::post('/agenda/tambahagenda', 'AgendaController@tambahagenda');
Route::get('/agenda/hapus/{id}', 'AgendaController@delete');
Route::get('/agenda/edit/{id}', 'AgendaController@edit');
Route::post('/agenda/update/{id}', 'AgendaController@update');
Route::get('/agenda/cari', 'AgendaController@cari');
Route::post('/agenda/verifikasi', 'AgendaController@verifikasi');
Route::get('/agenda/selesai/{id}', 'AgendaController@selesai');
//Notulen
Route::post('/notulen/save/{id}', 'AgendaController@notulen');
Route::post('/notulen/upload/{id}', 'AgendaController@upload');
Route::get('/notulen/view/{id}', 'AgendaController@view');
//Daftar Hadir
Route::post('/daftarhadir/upload/{id}', 'AgendaController@daftarhadir');
Route::get('/daftarhadir/view/{id}', 'AgendaController@viewdaftar');
//Materi
Route::post('/materi/upload/{id}', 'AgendaController@materi');
Route::get('/materi/view/{id}', 'AgendaController@viewmateri');
//Materi
Route::post('/dokumentasi/upload/{id}', 'AgendaController@dokumentasi');
Route::get('/dokumentasi/view/{id}', 'AgendaController@viewdokumentasi');
//Undangan
Route::get('/agenda/undangan/{id}', 'AgendaController@undangan');
Route::post('/undangan/tambahpeserta/{id}', 'AgendaController@tambahpeserta');
Route::get('/undangan/{id}/hapus/{ids}', 'AgendaController@deleteundangan');
Route::get('/undangan/cari/{id}', 'AgendaController@cariundangan');
Route::get('/undangan/view/{id}', 'AgendaController@cetakundangan');
//Presensi
Route::get('/presensi', 'PresensiController@index');
Route::get('/presensi/hadir/{id}', 'PresensiController@hadir');
Route::get('/presensi/hadir_pdf/{id}', 'PresensiController@cetakhadir');
Route::get('/presensi/email/{id}', 'PresensiController@brute_email');
Route::get('/presensi/{id}/email/{ids}', 'PresensiController@email');
//tamu
Route::get('/tamu', 'TamuController@index');
Route::post('/presensitamu', 'TamuController@presensi');
//about
Route::get('/about', 'AboutController@index');
Route::post('/about/upload', 'AboutController@upload');
Route::get('/about/view/{id}', 'AboutController@view');
Route::get('/about/delete/{id}', 'AboutController@delete');
//profil
Route::get('/profil', 'ProfilController@index');
Route::post('/profil/update/{id}', 'ProfilController@update');
//link email
Route::get('/notifikasi/{id}/{ids}', 'PresensiLinkController@index');
//berbahaya
Route::get('/presensi/{id}/{ids}', 'PresensiController@presensi');
