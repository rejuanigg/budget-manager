<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('transactions', TransactionController::class)->names('api.');
    Route::apiResource("categories", CategoryController::class)->names('api.');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('tags', \App\Http\Controllers\Api\TagController::class)->names('api.');
});
