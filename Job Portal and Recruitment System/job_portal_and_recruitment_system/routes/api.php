<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;

Route::prefix('auth')->controller(JWTAuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->middleware('throttle:10,1');

    Route::middleware(['auth:api'])->group(function () {
        Route::get('logout', 'logout');
    });
});

Route::prefix('job')->middleware(['auth:api', 'role.employer'])->controller(JobController::class)->group(function () {
    Route::post('create', 'createJob');
    Route::get('list', 'listJobs');
    Route::delete('delete/{id}', 'deleteJob')->where('id', '[0-9]+');  // Use DELETE method for delete
    Route::get('fetch/{id}', 'fetchJobById')->where('id', '[0-9]+');
    Route::post('update/{id}', 'updateJob')->where('id', '[0-9]+');
});

Route::prefix('profile')->controller(ProfileController::class)->middleware('auth:api')->group(function () {
    Route::post('set', 'setProfile');
    Route::get('get/{id}', 'getProfile');
});

Route::prefix('job-seeker')->controller(JobSeekerController::class)->middleware(['auth:api', 'role.job_seeker'])->group(function () {
    Route::post('search', 'searchJob');
});


//        Route::get('users/{role}', 'showUsers');  // Could change to '/user-role/{role}' for SEO purposes, if needed



