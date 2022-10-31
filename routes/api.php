<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/users')->group(function () {
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('', [UserController::class, 'create']);
    Route::post('/{id}', [UserController::class, 'update']);
    Route::get('', [UserController::class, 'index']);
    Route::delete('/{id}', [UserController::class, 'delete']);
});
