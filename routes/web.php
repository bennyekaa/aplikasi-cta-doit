<?php

use App\Http\Controllers\Beranda\BerandaController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Master\Kategori\KategoriController;
use App\Http\Controllers\Master\Modul\ModulController;
use App\Http\Controllers\Master\Pengguna\PenggunaController;
use App\Http\Controllers\Master\Soal\SoalController;
use App\Http\Controllers\Register\RegisterController;
use App\Http\Controllers\Ujian\RiwayatController;
use App\Http\Controllers\Ujian\UjianController;
use App\Http\Controllers\Master\RiwayatUjian\RiwayatUjianController;
use App\Http\Controllers\BackupRestoreController;
use App\Models\Master\KategoriSoal;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


use App\Http\Controllers\SebController;

Route::get('download-seb-config', [SebController::class, 'downloadConfig']);
Route::get('login', [LoginController::class, 'index']);
Route::post('actionlogin', [LoginController::class, 'actionlogin']);
Route::get('logout', [LoginController::class, 'logout']);

Route::get('register', [RegisterController::class, 'index']);
Route::post('actionregister', [RegisterController::class, 'actionregister']);

Route::get('admin', function () {
    return redirect('login');
});

Route::middleware('checklogin')->group(function () {

    Route::get('/', [BerandaController::class, 'index']);

    Route::prefix('master')->group(function () {
        Route::prefix('pengguna')->group(function () {
            Route::get('index', [PenggunaController::class, 'index']);
            Route::get('tambah', [PenggunaController::class, 'tambah']);
            Route::get('edit/{id}', [PenggunaController::class, 'edit']);
            Route::get('hapus/{id}', [PenggunaController::class, 'hapus']);
            Route::get('status/{id}/{id1}', [PenggunaController::class, 'status']);
            Route::get('jadwal/{id}', [PenggunaController::class, 'jadwal']);
            Route::get('password/{id}', [PenggunaController::class, 'password']);
            Route::post('proses', [PenggunaController::class, 'proses']);
            Route::get('template', [PenggunaController::class, 'template']);
            Route::post('import', [PenggunaController::class, 'import']);
        });
        Route::prefix('jabatan')->group(function () {
            Route::get('index', [\App\Http\Controllers\Master\Jabatan\JabatanController::class, 'index']);
            Route::get('tambah', [\App\Http\Controllers\Master\Jabatan\JabatanController::class, 'tambah']);
            Route::get('edit/{id}', [\App\Http\Controllers\Master\Jabatan\JabatanController::class, 'edit']);
            Route::get('hapus/{id}', [\App\Http\Controllers\Master\Jabatan\JabatanController::class, 'hapus']);
            Route::post('proses', [\App\Http\Controllers\Master\Jabatan\JabatanController::class, 'proses']);
        });
        Route::prefix('kecamatan')->group(function () {
            Route::get('index', [\App\Http\Controllers\Master\Kecamatan\KecamatanController::class, 'index']);
            Route::get('tambah', [\App\Http\Controllers\Master\Kecamatan\KecamatanController::class, 'tambah']);
            Route::get('edit/{id}', [\App\Http\Controllers\Master\Kecamatan\KecamatanController::class, 'edit']);
            Route::get('hapus/{id}', [\App\Http\Controllers\Master\Kecamatan\KecamatanController::class, 'hapus']);
            Route::post('proses', [\App\Http\Controllers\Master\Kecamatan\KecamatanController::class, 'proses']);
        });
        Route::prefix('desa')->group(function () {
            Route::get('index', [\App\Http\Controllers\Master\Desa\DesaController::class, 'index']);
            Route::get('tambah', [\App\Http\Controllers\Master\Desa\DesaController::class, 'tambah']);
            Route::get('edit/{id}', [\App\Http\Controllers\Master\Desa\DesaController::class, 'edit']);
            Route::get('hapus/{id}', [\App\Http\Controllers\Master\Desa\DesaController::class, 'hapus']);
            Route::post('proses', [\App\Http\Controllers\Master\Desa\DesaController::class, 'proses']);
        });

        // Bank Soal
        Route::prefix('bank_soal')->group(function () {
            Route::get('/index', 'App\Http\Controllers\Master\BankSoal\BankSoalController@index');
            Route::get('/template', 'App\Http\Controllers\Master\BankSoal\BankSoalController@template');
            Route::post('/import', 'App\Http\Controllers\Master\BankSoal\BankSoalController@import');
            Route::get('/hapus/{id}', 'App\Http\Controllers\Master\BankSoal\BankSoalController@hapus');
            Route::post('/hapus-bulk', 'App\Http\Controllers\Master\BankSoal\BankSoalController@bulkHapus');
            Route::get('/get-tematik/{id_modul}', 'App\Http\Controllers\Master\BankSoal\BankSoalController@getTematikByModul');
        });

        Route::prefix('kategori')->group(function () {
            Route::get('index', [KategoriController::class, 'index']);
            Route::get('tambah', [KategoriController::class, 'tambah']);
            Route::get('edit/{id}', [KategoriController::class, 'edit']);
            Route::get('hapus/{id}', [KategoriController::class, 'hapus']);
            Route::get('status/{id}/{id1}', [KategoriController::class, 'status']);
            Route::post('proses', [KategoriController::class, 'proses']);
        });
        Route::prefix('modul')->group(function () {
            Route::get('index', [ModulController::class, 'index']);
            Route::get('tambah', [ModulController::class, 'tambah']);
            Route::get('edit/{id}', [ModulController::class, 'edit']);
            Route::get('hapus/{id}', [ModulController::class, 'hapus']);
            Route::get('status/{id}/{id1}', [ModulController::class, 'status']);
            Route::post('proses', [ModulController::class, 'proses']);
        });
        Route::prefix('soal')->group(function () {
            Route::get('index', [SoalController::class, 'index']);
            Route::get('list', [SoalController::class, 'list']);
            Route::get('detail/list/{id}', [SoalController::class, 'detail_list']);
            Route::get('add/{id}', [SoalController::class, 'add']);
            Route::get('hapus/{id}', [SoalController::class, 'hapus']);
            Route::post('proses', [SoalController::class, 'proses']);
            Route::post('import', [SoalController::class, 'import']);
        });

        Route::prefix('riwayat_ujian')->group(function () {
            Route::get('index', [RiwayatUjianController::class, 'index']);
            Route::get('detail/{id}', [RiwayatUjianController::class, 'detail']);
            Route::get('cetak/{id}', [RiwayatUjianController::class, 'cetak']);
        });
    });

    Route::prefix('ujian')->group(function () {
        Route::get('list', [UjianController::class, 'list'])->name('ujian.list');
        Route::get('detail/{id}', [UjianController::class, 'detail']);
        Route::get('input/{id}', [UjianController::class, 'input']);
        Route::get('selesai/{id}', [UjianController::class, 'selesai']);
        Route::get('mulai/{id}/{id1}', [UjianController::class, 'mulai'])->name('ujian.mulai');
        Route::get('jawab/{id}/{id1}', [UjianController::class, 'jawab']);
        Route::get('index', [UjianController::class, 'index']);
        Route::get('riwayat', [RiwayatController::class, 'index']);
        Route::get('detail/riwayat/{id}/{id1}', [RiwayatController::class, 'detail']);
        Route::get('pembahasan/{id}/{id1}/{id2}', [RiwayatController::class, 'pembahasan']);
    });

    Route::get('/get-countdown-time/{id}', [UjianController::class, 'getCountdownTime']);
    Route::post('/update-countdown-time', [UjianController::class, 'updateCountdownTime']);

    Route::post('/simpan_waktu', [UjianController::class, 'updatewaktu']);

    Route::post('/simpan_ujian', [UjianController::class, 'simpanujian']);

    Route::prefix('pengaturan')->group(function () {
        Route::get('/', [\App\Http\Controllers\PengaturanController::class, 'index']);
        Route::post('proses', [\App\Http\Controllers\PengaturanController::class, 'proses']);
    });

    Route::prefix('backup-restore')->group(function () {
        Route::get('/', [BackupRestoreController::class, 'index']);
        Route::get('/backup', [BackupRestoreController::class, 'backup']);
        Route::post('/restore', [BackupRestoreController::class, 'restore']);
    });

    Route::get('/reset', function () {
        \Illuminate\Support\Facades\DB::table('user_exam_answers')->truncate();
        \Illuminate\Support\Facades\DB::table('user_exams')->truncate();
        return redirect('ujian/list');
    });

});
