<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('register')->group(function () {
    Route::post('recruiter', [AuthController::class, 'recruiterRegister']);
    Route::post('job-seeker', [AuthController::class, 'jobSeekerRegister']);
});

Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('jobs', JobController::class);

Route::post('/jobs/{id}/restore', [JobController::class, 'restore']);
Route::post('/jobs/{id}/force-delete', [JobController::class, 'forceDelete']);

Route::get('/my-jobs', [JobController::class, 'myJobs'])->middleware('auth:sanctum');
Route::get('/my-deleted-jobs', [JobController::class, 'myDeletedJobs'])->middleware('auth:sanctum');
