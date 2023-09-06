<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Card\CardController;
use App\Http\Controllers\Card\CardSwitcherTaskController;
use App\Http\Controllers\Merchant\MerchantController;

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

// Authentication routes
Route::group(['prefix' => '/auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

// Routes that require authentication with 'auth:sanctum' middleware
Route::middleware('auth:sanctum')->group(function () {
    // Card creation route
    Route::post('/cards', [CardController::class, 'create']);

    // Card Switcher routes
    Route::post('/tasks', [CardSwitcherTaskController::class, 'createTask']);
    Route::put('/tasks/{taskId}/finish', [CardSwitcherTaskController::class, 'markTaskAsFinished']);
    Route::put('/tasks/{taskId}/fail', [CardSwitcherTaskController::class, 'markTaskAsFailed']);
    
    // Latest Finished Tasks
    Route::get('/user/{userId}/latest-tasks', [CardSwitcherTaskController::class, 'latestFinishedTasks']);
});

// Public routes (not protected by authentication middleware)
Route::get('/merchants', [MerchantController::class, 'index']);
