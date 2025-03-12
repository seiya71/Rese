<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
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

Route::get('/', [ShopController::class, 'index']);

Route::get('/detail', [ShopController::class, 'detail']);

Route::post('register', [UserController::class, 'register']);

Route::get('/thanks', [UserController::class, 'thanks']);

Route::get('/login', [UserController::class, 'login']);

Route::get('/mypage', [UserController::class, 'mypage']);

Route::get('/done', [ShopController::class, 'done']);