<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;

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

Route::get('/', [ShopController::class, 'index']);

Route::get('/detail', [ShopController::class, 'detail']);

Route::post('register', [UserController::class, 'register']);

Route::get('/thanks', [UserController::class, 'thanks']);

Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');

    Route::post('/email/resend', [EmailVerificationController::class, 'resend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.resend');
});

Route::get('/login', [UserController::class, 'login']);

Route::get('/mypage', [UserController::class, 'mypage']);

Route::get('/done', [ShopController::class, 'done']);