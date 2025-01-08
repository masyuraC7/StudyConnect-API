<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\MaterialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rute untuk kelas
Route::middleware('auth:sanctum')->group(callback: function () {
    Route::post('/classes', [ClassController::class, 'store']);
    Route::get('/classes', [ClassController::class, 'show']);
    Route::put('/classes/{id}', [ClassController::class, 'update']);
    Route::delete('/classes/{id}', [ClassController::class, 'destroy']);
    Route::post('/classes/{code}/join', [ClassController::class, 'join']);
    Route::post('/classes/{code}/leave', [ClassController::class, 'leave']);    
});
// Rute untuk materi
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/material/{class_id}', [MaterialController::class, 'store']);
    Route::get('/material/{class_id}', [MaterialController::class, 'show']);
    Route::put('/material/{id}', [MaterialController::class, 'update']);
    Route::delete('/material/{id}', [MaterialController::class, 'destroy']);
});
// Rute untuk pengumuman
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/announcement/{class_id}', [AnnouncementController::class, 'store']);
    Route::get('/announcement/{class_id}', [AnnouncementController::class, 'show']);
    Route::put('/announcement/{id}', [AnnouncementController::class, 'update']);
    Route::delete('/announcement/{id}', [AnnouncementController::class, 'destroy']);
});