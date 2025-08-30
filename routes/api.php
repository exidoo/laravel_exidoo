<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HospitalController;
use App\Http\Controllers\API\PatientController;

/*
|--------------------------------------------------------------------------|
| API Routes                                                                |
|--------------------------------------------------------------------------|
| Here is where you can register API routes for your application. These    |
| routes are loaded by the RouteServiceProvider and all of them will be    |
| assigned to the "api" middleware group. Make something great!            |
|--------------------------------------------------------------------------|
*/

// Route::prefix('v1')->group(function () {
//     Route::prefix('auth')->group(function () {
//         Route::post('register', [AuthController::class, 'register']);
//         Route::post('login', [AuthController::class, 'login']);
//         Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:jwt');
//     });

//     // Routes untuk Hospital
//     Route::middleware('auth:api')->group(function () {
//         Route::apiResource('hospitals', HospitalController::class);
//         Route::apiResource('patients', PatientController::class);
//     });
// });
