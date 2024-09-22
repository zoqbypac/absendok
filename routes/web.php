<?php

use App\Http\Controllers\AbsendokController;
use App\Http\Controllers\MasterAbsensi;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    //Absendok
    Route::get('/dashboard', [AbsendokController::class, 'index'])->name('dashboard');
    Route::post('/absendok', [AbsendokController::class, 'absendok'])->name('absendok');
    Route::get('/absenpulang/{id}', [AbsendokController::class, 'absenpulang'])->name('absenpulang');
    Route::get('/rekapabsen', [AbsendokController::class, 'rekapabsen'])->name('rekapabsen');
    Route::get('/rekapabsen/dokter', [AbsendokController::class, 'rekapabsendok'])->name('rekapabsendok');
    Route::get('/rekapabsen/poli', [AbsendokController::class, 'rekapabsenpoli'])->name('rekapabsenpoli');
    Route::get('/rekapabsen/ns', [AbsendokController::class, 'rekapabsenns'])->name('rekapabsenns');
    Route::get('/chatgroup', [AbsendokController::class, 'chatgroup'])->name('chatgroup');
    Route::get('/getchatgroup', [AbsendokController::class, 'getchatgroup'])->name('getchatgroup');
    Route::get('/getinfo', [AbsendokController::class, 'getinfo'])->name('getinfo');
    Route::get('/cekinfo', [AbsendokController::class, 'cekinfo']);
    Route::get('/rekapabsen/export/', [AbsendokController::class, 'export'])->name('xrekapabsen');
    Route::get('/rekapabsen/dokter/export/', [AbsendokController::class, 'exportdok'])->name('xrekapabsendok');
    Route::get('/rekapabsen/poli/export/', [AbsendokController::class, 'exportpoli'])->name('xrekapabsenpoli');
    Route::get('/rekapabsen/ns/export/', [AbsendokController::class, 'exportns'])->name('xrekapabsenns');
    Route::get('/jadwaldokter', [AbsendokController::class, 'jadwal'])->name('jadwaldokter');
    Route::post('/jadwalstore', [AbsendokController::class, 'jadwalstore'])->name('jadwalstore');
    Route::get('xjadwaldokter', [AbsendokController::class, 'xjadwal'])->name('xjadwaldokter');
    Route::post('/inputjadwal', [AbsendokController::class, 'inputjadwal'])->name('inputjadwal');
    Route::post('/jadwalcuti', [AbsendokController::class, 'jadwalcuti'])->name('jadwalcuti');
    Route::get('/hapuscuti', [AbsendokController::class, 'hapuscuti'])->name('hapuscuti');
    Route::get('/hapusjadwal', [AbsendokController::class, 'hapusjadwal'])->name('hapusjadwal');
    Route::get('/hapusjadwal/{id}', [AbsendokController::class, 'xhapusjadwal'])->name('xhapusjadwal');
    Route::get('/mappingpoli',[AbsendokController::class, 'mapping'])->name('mappingpoli');
    Route::post('/mappingstore', [AbsendokController::class, 'mappingstore'])->name('mappingstore');
    Route::get('/viewjadwal', [AbsendokController::class, 'viewjadwal'])->name('viewjadwal');
    Route::get('/ubahjadwal/{id}', [AbsendokController::class, 'ubahjadwal'])->name('ubahjadwal');

    //alasan
    Route::get('jenis-alasan', [MasterAbsensi::class, 'alasan'])->name('jenis.alasan');
    Route::get('jenis-alasan/{id}', [MasterAbsensi::class, 'alasanedit'])->name('edit.alasan');
    Route::post('jenis-alasan', [MasterAbsensi::class, 'alasanstore'])->name('store.alasan');
    Route::patch('jenis-alasan/{id}/update', [MasterAbsensi::class, 'alasanupdate'])->name('update.alasan');
    Route::delete('jenis-alasan/{id}/delete', [MasterAbsensi::class, 'alasandelete'])->name('delete.alasan');
    Route::post('alasan-terlambat/{id}', [MasterAbsensi::class, 'alasanterlambat'])->name('alasan.terlambat');

    //User
    Route::get('/daftaruser',[UsersController::class, 'index'])->name('daftaruser');
    Route::post('/userstore', [UsersController::class, 'store'])->name('userstore');
    Route::post('/register', [UsersController::class, 'userstore'])->name('register');
    Route::get('/hapususer/{id}', [UsersController::class, 'hapus'])->name('hapususer');
    Route::post('/ubahpassword', [UsersController::class, 'ubahpassword'])->name('ubahpassword');

    //ns
    Route::get('master-ns', [MasterAbsensi::class, 'ns'])->name('index.ns');
    Route::get('master-ns/{id}', [MasterAbsensi::class, 'nsedit'])->name('edit.ns');
    Route::post('master-ns', [MasterAbsensi::class, 'nsstore'])->name('store.ns');
    Route::patch('master-ns/{id}/update', [MasterAbsensi::class, 'nsupdate'])->name('update.ns');
    Route::delete('master-ns/{id}/delete', [MasterAbsensi::class, 'nsdelete'])->name('delete.ns');

    //mapping ns
    Route::get('mapping-ns', [MasterAbsensi::class, 'mappingns'])->name('index.mappingns');
    Route::get('mapping-ns/{id}', [MasterAbsensi::class, 'mappingnsedit'])->name('edit.mappingns');
    Route::post('mapping-ns', [MasterAbsensi::class, 'mappingnsstore'])->name('store.mappingns');
    Route::patch('mapping-ns/{id}/update', [MasterAbsensi::class, 'mappingnsupdate'])->name('update.mappingns');
    Route::delete('mapping-ns/{id}/delete', [MasterAbsensi::class, 'mappingnsdelete'])->name('delete.mappingns');
});


require __DIR__.'/auth.php';
