<?php

use App\Http\Controllers\Data\Users\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->namespace('Users')->group(function() {
    Route::get('/', [UsersController::class, 'index']);
    Route::post('/', [UsersController::class, 'store']);
    Route::delete('/{id}', [UsersController::class, 'destroy']);
});

