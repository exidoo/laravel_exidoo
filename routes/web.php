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



// Rute yang dilindungi dengan middleware auth
Route::middleware('auth')->group(function () {
    // Rute untuk halaman rumah sakit
    Route::get('/hospitals', [HospitalControllerWeb::class, 'index'])->name('hospitals.index');
    Route::get('/hospitals/{id}', [HospitalControllerWeb::class, 'show']);


    Route::resource('hospitals', HospitalControllerWeb::class);
    Route::resource('patients', PatientControllerWeb::class);
    Route::get('/patients/filter/{hospitalId?}', [PatientControllerWeb::class, 'filterByHospital']);
});
