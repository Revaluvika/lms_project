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


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;

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

// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);

    // Parent Routes
    Route::prefix('parent')->group(function () {
        Route::get('/children', [ParentController::class, 'children']);
        Route::get('/attendance', [ParentController::class, 'attendance']);
        Route::get('/schedule', [ParentController::class, 'schedule']);
        Route::get('/grades', [ParentController::class, 'grades']);
    });

    // Student Routes
    Route::prefix('student')->group(function () {
        Route::get('/schedule', [StudentController::class, 'schedule']);
        Route::get('/assignments', [StudentController::class, 'assignments']);
    });

    // Teacher Routes
    Route::prefix('teacher')->group(function () {
        Route::get('/schedule', [TeacherController::class, 'schedule']);
        Route::post('/attendance', [TeacherController::class, 'storeAttendance']);
    });
});
