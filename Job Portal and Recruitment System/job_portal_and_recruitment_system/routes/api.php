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
        Route::post('logout', 'logout');
        Route::get('users/{role}', 'showUsers');
    });
});

Route::prefix('job')->middleware(['auth:api' , 'role.employer'])->controller(JobController::class)->group(function () {
    Route::post('create_job', 'createJob');
    Route::get('list_jobs', 'listJobs');
    Route::get('delete_job/{id}', 'deleteJob')->where('id', '[0-9]+');
    Route::get('fetch_job/{id}', 'fetchJobById')->where('id', '[0-9]+');
    Route::post('update_job/{id}', 'updateJob')->where('id', '[0-9]+');
});

Route::prefix('profile')->controller(ProfileController::class)->middleware('auth:api')->group(function () {
    Route::post('set_profile', 'setProfile');
    Route::get('get_profile/{id}', 'getProfile');
});


Route::prefix('job_seeker')->controller(JobSeekerController::class)->middleware(['auth:api' , 'role.job_seeker'])->group(function () {
    Route::post('search_job', 'searchJob');
});





