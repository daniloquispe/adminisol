<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ubigeo
Route::get('departments', [\App\Http\Controllers\Api\UbigeoController::class, 'departments']);
Route::get('department/{id}', [\App\Http\Controllers\Api\UbigeoController::class, 'department']);
Route::get('provinces/{departmentId}', [\App\Http\Controllers\Api\UbigeoController::class, 'provinces']);
Route::get('province/{id}', [\App\Http\Controllers\Api\UbigeoController::class, 'province']);
Route::get('districts/{provinceId}', [\App\Http\Controllers\Api\UbigeoController::class, 'districts']);
Route::get('district/{id}', [\App\Http\Controllers\Api\UbigeoController::class, 'district']);
