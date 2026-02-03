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
Route::get('/pegawai', 'PegawaiController@index')->name('pegawai.home');
Route::get('/pegawai/tambah', 'PegawaiController@tambah')->name('pegawai.tambah');
Route::post('/pegawai/tambahpegawai', 'PegawaiController@tambahpegawai')->name('pegawai.tambahpegawai');
Route::get('/pegawai/edit/{id}', 'PegawaiController@edit')->name('pegawai.edit');
Route::post('/pegawai/update/{id}', 'PegawaiController@update')->name('pegawai.update');
Route::get('/pegawai/hapus/{id}', 'PegawaiController@delete')->name('pegawai.delete');
Route::get('/pegawai/cari', 'PegawaiController@cari')->name('pegawai.cari');
Route::post('/pegawai/import_excel', 'PegawaiController@import_excel')->name('pegawai.import');
//Unit
Route::get('/unit', 'UnitController@index')->name('unit.home');
Route::get('/unit/tambah', 'UnitController@tambah')->name('unit.tambah');
Route::post('/unit/tambahunit', 'UnitController@tambahunit')->name('unit.tambahunit');
Route::get('/unit/edit/{id}', 'UnitController@edit')->name('unit.edit');
Route::put('/unit/update/{id}', 'UnitController@update')->name('unit.update');
Route::get('/unit/hapus/{id}', 'UnitController@delete')->name('unit.hapus');
Route::get('/unit/cari', 'UnitController@cari')->name('unit.cari');
//Ruangan
Route::get('/ruangan', 'RuanganController@index')->name('ruangan.home');
Route::get('/ruangan/tambah', 'RuanganController@tambah')->name('ruangan.tambah');
Route::post('/ruangan/tambahruangan', 'RuanganController@tambahruangan')->name('ruangan.tambahruangan');
Route::get('/ruangan/edit/{id}', 'RuanganController@edit')->name('ruangan.edit');
Route::put('/ruangan/update/{id}', 'RuanganController@update')->name('ruangan.update');
Route::get('/ruangan/hapus/{id}', 'RuanganController@delete')->name('ruangan.hapus');
//Agenda
Route::get('/agenda', 'AgendaController@index')->name('agenda.home');
Route::get('/agenda/tambah', 'AgendaController@tambah')->name('agenda.tambah');
Route::post('/agenda/tambahagenda', 'AgendaController@tambahagenda')->name('agenda.tambahagenda');
Route::get('/agenda/hapus/{id}', 'AgendaController@delete')->name('agenda.hapus');
Route::get('/agenda/edit/{id}', 'AgendaController@edit')->name('agenda.edit');
Route::post('/agenda/update/{id}', 'AgendaController@update')->name('agenda.update');
Route::get('/agenda/cari', 'AgendaController@cari')->name('agenda.cari');
Route::post('/agenda/verifikasi', 'AgendaController@verifikasi')->name('agenda.verifikasi');
Route::get('/agenda/selesai/{id}', 'AgendaController@selesai')->name('agenda.selesai');
//Notulen
Route::post('/notulen/save/{id}', 'AgendaController@notulen');
Route::post('/notulen/upload/{id}', 'AgendaController@upload');
Route::get('/notulen/view/{id}', 'AgendaController@view');
Route::get('/notulen/{id}/delete', 'AgendaController@delete_notulen');
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
Route::get('/presensi', 'PresensiController@index')->name('presensi.home');
Route::get('/presensi/hadir/{id}', 'PresensiController@hadir')->name('presensi.hadir');
Route::get('/presensi/hadir_pdf/{id}', 'PresensiController@cetakhadir')->name('presensi.cetakhadir');
Route::get('/presensi/email/{id}', 'PresensiController@brute_email')->name('presensi.bruteemail');
Route::get('/presensi/{id}/email/{ids}', 'PresensiController@email')->name('presensi.email');

Route::get('/timeline', 'TimelineController@index')->name('timeline.home');
Route::get('/timeline/tambah', 'TimelineController@tambah')->name('timeline.tambah');
Route::post('/timeline/store', 'TimelineController@store')->name('timeline.store');
Route::get('/timeline/{id}/delete', 'TimelineController@delete')->name('timeline.delete');
Route::get('/timeline/{id}/edit', 'TimelineController@edit')->name('timeline.edit');
Route::post('/timeline/update', 'TimelineController@update')->name('timeline.update');
Route::get('/timeline/{id}/detail', 'TimelineController@detail')->name('timeline.detail');
Route::post('/timeline/bukti', 'TimelineController@bukti')->name('timeline.bukti');
Route::get('/timeline/bukti/{id}/delete', 'TimelineController@deleteBukti')->name('timeline.deleteBukti');
Route::get('/timeline/bukti/{id}/view', 'TimelineController@viewBukti')->name('timeline.viewBukti');
Route::post('/timeline/catatan/store', 'TimelineController@catatan')->name('timeline.catatan');
Route::post('/timeline/catatan/save', 'TimelineController@saveCatatan')->name('timeline.saveCatatan');
Route::get('/timeline/catatan/{id}/delete', 'TimelineController@deleteCatatan')->name('timeline.deleteCatatan');
Route::get('/timeline/dashboard', 'TimelineController@dashboard')->name('timeline.dashboard');
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
