<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('register')->group(function () {
    Route::post('recruiter', [AuthController::class, 'recruiterRegister']);
    Route::post('job-seeker', [AuthController::class, 'jobSeekerRegister']);
});

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

Route::apiResource('jobs', JobController::class)->only(['index', 'show']);

Route::middleware(['auth:sanctum', 'recruiter'])->group(function () {
    Route::prefix('recruiter')->name('recruiter.')->group(function () {
        Route::apiResource('jobs', JobController::class)->except(['index', 'show']);
        Route::get('/jobs/mine', [JobController::class, 'myJobs'])->name('jobs.mine');
    });
});

Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('jobs', [\App\Http\Controllers\Admin\JobController::class, 'index'])->name('jobs.index');
    Route::post('/jobs/{id}/restore', [\App\Http\Controllers\Admin\JobController::class, 'restore'])->name('jobs.restore');
    Route::post('/jobs/{id}/force-delete', [\App\Http\Controllers\Admin\JobController::class, 'forceDelete'])->name('jobs.forceDelete');
});



Route::get('/admin/work-profile', [WorkProfileController::class, 'index'])->middleware('auth:sanctum');
