<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkProfileController;
use App\Models\WorkProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//Auth routes
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');


Route::prefix('register')->group(function () {
    Route::post('recruiter', [AuthController::class, 'recruiterRegister']);
    Route::post('job-seeker', [AuthController::class, 'jobSeekerRegister']);
});
//general routes
Route::apiResource('jobs', JobController::class)->only(['index', 'show']);
Route::get('/work-profiles', [WorkProfileController::class, 'index']);
Route::get('/work-profiles/{id}', [WorkProfileController::class, 'view']);
Route::get('/tags', [TagController::class, 'index']);

//recruiter-specific routes
Route::middleware(['auth:sanctum', 'recruiter'])->group(function () {
    Route::prefix('recruiter')->name('recruiter.')->group(function () {
        Route::get('company', [CompanyController::class, 'show']);
        Route::put('company', [CompanyController::class, 'update']);
        Route::delete('company', [CompanyController::class, 'destroy']);

        Route::apiResource('jobs', JobController::class)->except(['index', 'show']);
        Route::get('/jobs/mine', [JobController::class, 'myJobs'])->name('jobs.mine');
    });
});
//admin-specific routes
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('jobs', [\App\Http\Controllers\Admin\JobController::class, 'index'])->name('jobs.index');
    Route::post('/jobs/{id}/restore', [\App\Http\Controllers\Admin\JobController::class, 'restore'])->name('jobs.restore');
    Route::post('/jobs/{id}/force-delete', [\App\Http\Controllers\Admin\JobController::class, 'forceDelete'])->name('jobs.forceDelete');

    Route::get('companies', [App\Http\Controllers\Admin\CompanyController::class, 'index']);
    Route::post('companies/{id}/toggle-ban', [App\Http\Controllers\Admin\CompanyController::class, 'toggleBan'])->name('companies.toggleBan');

    Route::apiResource('categories', CategoryController::class)->except(['show']);

    Route::delete('tags/{id}',[TagController::class,'destroy']);
});

//job-seeker-specific routes
Route::prefix('job-seeker')->middleware(['auth:sanctum', 'job_seeker'])->group(function () {
    Route::put('work-profile', [WorkProfileController::class, 'update']);
    Route::get('work-profile', [WorkProfileController::class, 'show']);
    Route::post('work-profile/toggle-activation', [WorkProfileController::class, 'toggleActivate']);
});
