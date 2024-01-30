<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::post("login", [AuthController::class,'login']);
Route::post("register", [AuthController::class,'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get("dashboard", [AuthController::class,'dashboard'])->name('dashboard');

    Route::apiResource('tasks', TaskController::class);
});
