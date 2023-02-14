<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SensorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Endpoints for authentication
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated endpoints for services

// sensors
Route::post('/sensors/sync', [SensorController::class, 'syncSensorData'])->middleware(['auth:api']);
Route::get('/sensors', [SensorController::class, 'index'])->middleware(['auth:api']);

// devices
Route::resource('/devices', DeviceController::class)->middleware(['auth:api']);
