<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredJobSeekerController;
use App\Http\Controllers\RegisteredRecruiterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WorkProfileController;
use Illuminate\Support\Facades\Route;

Route::get("/", [JobController::class, 'home'])->name('home');

Route::get("/jobs", [JobController::class, 'index']);
Route::post("/jobs", [JobController::class, 'store'])->middleware(['auth', 'recruiter']);
Route::get("/jobs/create", [JobController::class, 'create'])->middleware(['auth', 'recruiter']);
Route::get("/jobs/{job}", [JobController::class, 'show']);
Route::post("/jobs/{job}", [JobController::class, 'update'])->middleware(['auth', 'recruiter']);
Route::delete("/jobs/{job}", [JobController::class, 'destroy'])->middleware(['auth', 'recruiter']);
Route::get("/jobs/{job}/edit", [JobController::class, 'edit'])->middleware(['auth', 'recruiter']);
Route::get("/search", SearchController::class);

Route::get("/companies", [CompanyController::class, "index"]);
Route::get("/companies/{company}", [CompanyController::class, "show"]);
Route::get("/tags/{tag:name}", TagController::class);

Route::get("/login", [SessionController::class, 'create'])->name('login');
Route::post("/login", [SessionController::class, 'store']);

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware(['auth']);

Route::get("/register/job-seeker", [RegisteredJobSeekerController::class, 'create']);
Route::post("/register/job-seeker", [RegisteredJobSeekerController::class, 'store']);

Route::get("/register/recruiter", [RegisteredRecruiterController::class, 'create']);
Route::post("/register/recruiter", [RegisteredRecruiterController::class, 'store']);

Route::get("/profile/job-seeker", [WorkProfileController::class, 'index'])->middleware(['auth', 'job_seeker']);
Route::get("/profile/job-seeker/edit", [WorkProfileController::class, 'edit'])->middleware(['auth', 'job_seeker']);
Route::post("/profile/job-seeker/edit", [WorkProfileController::class, 'update'])->middleware(['auth', 'job_seeker']);

Route::get("/profile/recruiter", [CompanyController::class, 'view'])->middleware(["auth", "recruiter"]);
Route::get("/profile/recruiter/edit", [CompanyController::class, 'edit'])->middleware(["auth", "recruiter"]);
Route::post("/profile/recruiter/edit", [CompanyController::class, 'update'])->middleware(["auth", "recruiter"]);

Route::get("/jobs/{job}/apply", [ApplicationController::class, 'create'])->middleware(['auth', 'job_seeker']);
Route::post("/jobs/{job}/apply", [ApplicationController::class, 'store'])->middleware(['auth', 'job_seeker']);

Route::get("/jobs/{job}/applications", [ApplicationController::class, 'show']);
// Route::middleware(["auth", "recruiter"])->group(function () {
//     Route::post("/jobs", [JobController::class, 'store']);
//     Route::get("/jobs/create", [JobController::class, 'create']);
//     Route::post("/jobs/{job}", [JobController::class, 'update']);
//     Route::get("/jobs/{job}/edit", [JobController::class, 'edit']);
//     Route::get("/profile/recruiter", [CompanyController::class, 'view']);
//     Route::get("/profile/recruiter/edit", [CompanyController::class, 'edit']);
//     Route::post("/profile/recruiter/edit", [CompanyController::class, 'update']);
// });

// Route::middleware(["auth", "job_seeker"])->group(function () {
//     Route::get("/profile/job-seeker", [WorkProfileController::class, 'index']);
//     Route::get("/profile/job-seeker/edit", [WorkProfileController::class, 'edit']);
//     Route::post("/profile/job-seeker/edit", [WorkProfileController::class, 'update']);

//     Route::get("/jobs/{job}/apply", [ApplicationController::class, 'create']);
//     Route::post("/jobs/{job}/apply", [ApplicationController::class, 'store']);
// });
