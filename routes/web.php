<?php

use App\Http\Controllers\Beranda\BerandaController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Register\RegisterController;
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


Route::get('/', [BerandaController::class, 'index']);
Route::get('login', [LoginController::class, 'index']);
Route::get('register', [RegisterController::class, 'index']);
