<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FileGediController;
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
Route::post('/login', [AuthenticationController::class, 'login'])->name('api.user.login');
Route::get('/me', [AuthenticationController::class, 'me'])->middleware('auth:sanctum')->name('api.user.me');
Route::get('/logout', [AuthenticationController::class, 'destroy'])->middleware('auth:sanctum')->name('api.user.destroy');

Route::prefix('/gedi')->middleware('auth:sanctum')->group(function () {
    Route::get('/get', [FileGediController::class, 'get'])->name('api.gedi.get');
    Route::get('/index/{success?}/{active?}', [FileGediController::class, 'index'])->name('api.gedi.index');
    Route::post('/store', [FileGediController::class, 'store'])->name('api.gedi.store');
    Route::get('/show/{fileGedi}', [FileGediController::class, 'show'])->name('api.gedi.show');
    Route::put('/update/{fileGedi}', [FileGediController::class, 'update'])->name('api.gedi.update');
    Route::delete('/delete/{fileGedi}', [FileGediController::class, 'destroy'])->name('api.gedi.delete');
});
