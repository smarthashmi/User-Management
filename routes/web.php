<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('users')->namespace('Users')->name('user.')->middleware(['web', 'auth'])->group(function() {

        Route::get('/', [UsersController::class, 'index'])->name('dashboard');
});

//DataRoutes
Route::prefix('data')->namespace('Data')->middleware(['web', 'auth'])->group(base_path('routes/web/data.php'));
