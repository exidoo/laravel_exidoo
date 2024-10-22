<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControllerWeb;
use App\Http\Controllers\HospitalControllerWeb;
use App\Http\Controllers\PatientControllerWeb;

/*
|--------------------------------------------------------------------------|
| Web Routes                                                               |
|--------------------------------------------------------------------------|
|                                                                          |
| Here is where you can register web routes for your application. These    |
| routes are loaded by the RouteServiceProvider and all of them will be    |
| assigned to the "web" middleware group. Make something great!            |
|--------------------------------------------------------------------------|
*/

// Rute untuk halaman login
Route::get('/login', [AuthControllerWeb::class, 'getLoginPage'])->name('auth.login.page');

// Rute untuk halaman register
Route::get('/register', [AuthControllerWeb::class, 'getRegisterPage'])->name('auth.register.page');

// Rute untuk proses registrasi
Route::post('/register', [AuthControllerWeb::class, 'register'])->name('auth.register');

// Rute untuk proses login
Route::post('/login', [AuthControllerWeb::class, 'login'])->name('auth.login');

// Rute untuk logout
Route::post('/logout', [AuthControllerWeb::class, 'logout'])->name('auth.logout');

// Route default untuk mengarahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('auth.login.page');
});

// Rute yang dilindungi dengan middleware auth
Route::middleware('auth')->group(function () {
    // Rute untuk halaman rumah sakit
    Route::get('/hospital', [HospitalControllerWeb::class, 'getHospitalPage'])->name('hospitals.index');

    // Resource route untuk hospital
    Route::resource('/hospital', HospitalControllerWeb::class)->names(['index' => 'hospitals.index']);

    // Resource route untuk pasien
    Route::resource('/patients', PatientControllerWeb::class);
});
