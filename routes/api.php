<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;

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
// Public routes (no authentication required)
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'show']);

// Authenticated routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/getuser', [AuthController::class, 'getUser']);
    // Job routes
    Route::post('/jobs', [JobController::class, 'store'])->middleware('role:employer');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->middleware('role:employer');
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->middleware('role:employer');

    // Application routes
    Route::post('/applications', [ApplicationController::class, 'store'])->middleware('role:job_seeker');
    Route::get('/applications', [ApplicationController::class, 'index'])->middleware('role:employer');
    Route::get('/applications/{id}', [ApplicationController::class, 'show'])->middleware('role:employer,job_seeker');
    Route::post('/applications/{id}/update-status', [ApplicationController::class, 'update'])->middleware('role:employer');
    Route::delete('/applications/{id}', [ApplicationController::class, 'destroy'])->middleware('role:employer,job_seeker');
});

