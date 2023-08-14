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
    Route::get('/equipment', [App\Http\Controllers\API\EquipmentController::class, 'index']);
    Route::get('/equipment/{id}', [App\Http\Controllers\API\EquipmentController::class, 'show']);
    Route::post('/equipment', [App\Http\Controllers\API\EquipmentController::class, 'store'])->withoutMiddleware(['auth','web']);
    Route::put('/equipment/{id}', [App\Http\Controllers\API\EquipmentController::class, 'update']);
    Route::delete('/equipment/{id}', [App\Http\Controllers\API\EquipmentController::class, 'destroy']);

    Route::get('/equipment-type', [App\Http\Controllers\API\EquipmentTypeController::class, 'index']);


