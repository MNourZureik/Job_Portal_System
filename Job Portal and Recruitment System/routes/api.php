<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobSeekerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->middleware('throttle:10,1');

    Route::middleware(['auth:api'])->group(function () {
        Route::get('logout', 'logout');
    });
}); // Done

Route::prefix('profile')->middleware(['auth:api' , 'role'])->group(function () {
    Route::prefix('employer')->controller(EmployerController::class)->group(function () {
        Route::post('store', 'store');
        Route::put('update', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('show/{id}', 'show');
    }); // Done
    Route::prefix('admin')->controller(AdminController::class)->group(function () {
        Route::post('store', 'store');
        Route::put('update', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('show/{id}', 'show');
    }); // Done
    Route::prefix('job_seeker')->controller(JobSeekerController::class)->group(function () {
        Route::post('store', 'store');
        Route::put('update', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('show/{id}', 'show');
    }); // Done
});


