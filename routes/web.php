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


Route::get('login', [LoginController::class, 'index']);
Route::post('actionlogin', [LoginController::class, 'actionlogin']);
Route::get('logout', [LoginController::class, 'logout']);

Route::get('register', [RegisterController::class, 'index']);
Route::post('actionregister', [RegisterController::class, 'actionregister']);

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
            Route::post('proses', [SoalController::class, 'proses']);
            Route::post('import', [SoalController::class, 'import']);
        });
    });

    Route::prefix('ujian')->group(function () {
        Route::get('list', [UjianController::class, 'list'])->name('ujian.list');
        Route::get('detail/{id}', [UjianController::class, 'detail']);
        Route::get('input/{id}', [UjianController::class, 'input']);
        Route::get('selesai/{id}', [UjianController::class, 'selesai']);
        Route::get('mulai/{id}/{id1}/{id2}', [UjianController::class, 'mulai'])->name('ujian.mulai');
        Route::get('pembahasan/{id}/{id1}', [UjianController::class, 'pembahasan']);
        Route::get('jawab/{id}/{id1}/{id2}/{id3}', [UjianController::class, 'jawab']);
        // Route::post('jawab', [UjianController::class, 'jawab'])->name('ujian.jawab');;
        Route::get('index', [UjianController::class, 'index']);
        Route::get('riwayat', [RiwayatController::class, 'index']);
        Route::get('detail/riwayat/{id}/{id1}', [RiwayatController::class, 'detail']);
        Route::get('pembahasan/{id}/{id1}/{id2}', [RiwayatController::class, 'pembahasan']);
    });

    Route::get('/get-countdown-time/{id}', [UjianController::class, 'getCountdownTime']);
    Route::post('/update-countdown-time', [UjianController::class, 'updateCountdownTime']);

    Route::post('/simpan_waktu', [UjianController::class, 'updatewaktu']);

    Route::post('/simpan_ujian', [UjianController::class, 'simpanujian']);

});
