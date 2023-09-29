<?php

use App\Http\Controllers\Beranda\BerandaController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Master\Kategori\KategoriController;
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
            Route::get('jadwal/{id}', [PenggunaController::class, 'jadwal']);
            Route::post('proses', [PenggunaController::class, 'proses']);
        });
        Route::prefix('kategori')->group(function () {
            Route::get('index', [KategoriController::class, 'index']);
            Route::get('tambah', [KategoriController::class, 'tambah']);
            Route::post('proses', [KategoriController::class, 'proses']);
        });
        Route::prefix('soal')->group(function () {
            Route::get('index', [SoalController::class, 'index']);
            Route::get('add', [SoalController::class, 'add']);
            Route::post('import', [SoalController::class, 'import']);
        });
    });

    Route::prefix('ujian')->group(function () {
        Route::get('index', [UjianController::class, 'index']);
    });
});
