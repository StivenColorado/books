<?php

use App\Http\Controllers\AuthUserApiController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [BookController::class,  'index']);
Route::post('/', [AuthUserApiController::class,  'logout']);

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])
    ->name('home');
