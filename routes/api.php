<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\SubmissionController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(callback: function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user/{id}', [AuthController::class, 'getUserById']);

    // Rute untuk kelas
    Route::post('/classes', [ClassController::class, 'store']);
    Route::get('/classes', [ClassController::class, 'show']);
    Route::get('/classes/{id}', [ClassController::class, 'getById']);
    Route::put('/classes/{id}', [ClassController::class, 'update']);
    Route::delete('/classes/{id}', [ClassController::class, 'destroy']);
    Route::post('/classes/{code}/join', [ClassController::class, 'join']);
    Route::post('/classes/{code}/leave', [ClassController::class, 'leave']);
    Route::get('/classes/{id}/students', [ClassController::class, 'getStudents']);
    Route::post('/archive/{id}', [ClassController::class, 'archive']);
    Route::post('/restore/{id}', [ClassController::class, 'restore']);
    Route::get('/archived-classes', [ClassController::class, 'getArchivedClasses']);

    // Rute untuk materi
    Route::post('/material/{class_id}', [MaterialController::class, 'store']);
    Route::get('/material/{class_id}', [MaterialController::class, 'show']);
    Route::put('/material/{id}', [MaterialController::class, 'update']);
    Route::delete('/material/{id}', [MaterialController::class, 'destroy']);

    // Rute untuk pengumuman
    Route::post('/announcement/{class_id}', [AnnouncementController::class, 'store']);
    Route::get('/announcement/{class_id}', [AnnouncementController::class, 'show']);
    Route::put('/announcement/{id}', [AnnouncementController::class, 'update']);
    Route::delete('/announcement/{id}', [AnnouncementController::class, 'destroy']);

    // Rute untuk tugas
    Route::post('/assignment/{class_id}', [AssignmentController::class, 'store']);
    Route::get('/assignment/{class_id}', [AssignmentController::class, 'show']);
    Route::put('/assignment/{id}', [AssignmentController::class, 'update']);
    Route::delete('/assignment/{id}', [AssignmentController::class, 'destroy']);

    // Rute untuk pengumpulan
    Route::post('/assignment/{assignment_id}/submission', [SubmissionController::class, 'store']);
    Route::get('/assignment/{assignment_id}/submission', [SubmissionController::class, 'show']);
    Route::put('/submission/{submission_id}', [SubmissionController::class, 'score']);
});