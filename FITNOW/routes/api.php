<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\FitnessProgressController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('fitness-progresses', FitnessProgressController::class);
    Route::patch('fitness-progresses/{fitnessProgress}/status', [FitnessProgressController::class, 'updateStatus']);
});