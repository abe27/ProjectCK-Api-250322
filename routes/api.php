<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthenticationController::class, 'register'])->name('api.user.register');
Route::post('/login', [AuthenticationController::class, 'login'])->middleware('auth:sanctum')->name('api.user.login');
Route::get('/me', [AuthenticationController::class, 'me'])->middleware('auth:sanctum')->name('api.user.me');
