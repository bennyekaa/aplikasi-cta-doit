<?php

use App\Http\Controllers\Beranda\BerandaController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Master\Kategori\KategoriController;
use App\Http\Controllers\Master\Modul\ModulController;
use App\Http\Controllers\Master\Pengguna\PenggunaController;
use App\Http\Controllers\Master\Soal\SoalController;
use App\Http\Controllers\Register\RegisterController;
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
            Route::get('add', [SoalController::class, 'add']);
            Route::get('add/detail/{id}', [SoalController::class, 'add_detail']);
            Route::post('import', [SoalController::class, 'import']);
        });
    });

    Route::prefix('ujian')->group(function () {
        Route::get('list', [UjianController::class, 'list']);
        Route::get('detail', [UjianController::class, 'detail']);
        Route::get('index', [UjianController::class, 'index']);
    });
});
