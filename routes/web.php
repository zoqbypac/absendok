<?php

use App\Http\Controllers\AbsendokController;
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
    Route::get('/chatgroup', [AbsendokController::class, 'chatgroup'])->name('chatgroup');
    Route::get('/getchatgroup', [AbsendokController::class, 'getchatgroup'])->name('getchatgroup');
    Route::get('/getinfo', [AbsendokController::class, 'getinfo'])->name('getinfo');
    Route::get('/rekapabsen/export/', [AbsendokController::class, 'export'])->name('xrekapabsen');
    Route::get('/jadwaldokter', [AbsendokController::class, 'jadwal'])->name('jadwaldokter');
    Route::post('/jadwalstore', [AbsendokController::class, 'jadwalstore'])->name('jadwalstore');
    Route::get('xjadwaldokter', [AbsendokController::class, 'xjadwal'])->name('xjadwaldokter');
    Route::get('/inputjadwal', [AbsendokController::class, 'inputjadwal'])->name('inputjadwal');
    Route::post('/jadwalcuti', [AbsendokController::class, 'jadwalcuti'])->name('jadwalcuti');
    Route::get('/hapusjadwal', [AbsendokController::class, 'hapusjadwal'])->name('hapusjadwal');
    Route::get('/hapusjadwal/{id}', [AbsendokController::class, 'xhapusjadwal'])->name('xhapusjadwal');
    Route::get('/mappingpoli',[AbsendokController::class, 'mapping'])->name('mappingpoli');
    Route::post('/mappingstore', [AbsendokController::class, 'mappingstore'])->name('mappingstore');
    Route::get('/viewjadwal', [AbsendokController::class, 'viewjadwal'])->name('viewjadwal');

   //User
    Route::get('/daftaruser',[UsersController::class, 'index'])->name('daftaruser');
    Route::post('/userstore', [UsersController::class, 'store'])->name('userstore');
    Route::get('/hapususer/{id}', [UsersController::class, 'hapus'])->name('hapususer');
    Route::post('/ubahpassword', [UsersController::class, 'ubahpassword'])->name('ubahpassword');
});


require __DIR__.'/auth.php';
