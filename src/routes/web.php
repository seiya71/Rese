<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', [ShopController::class, 'index'])->name('home');

Route::get('/detail/{shopId}', [ShopController::class, 'detail']);

Route::post('register', [UserController::class, 'register'])->name('register');

Route::get('/thanks', [UserController::class, 'thanks'])->name('thanks');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

Route::get('/done', [ShopController::class, 'done'])->name('done');

Route::post('/addlike/{shopId}', [ShopController::class, 'addlike'])->name('addlike');

Route::post('/removelike/{shopId}', [ShopController::class, 'removelike'])->name('removelike');

Route::post('/clear-redirect-session', function () {
    Session::forget('redirect_after_login');
    return response()->json(['status' => 'cleared']);
})->name('clear_redirect_session');

Route::get('/search', [ShopController::class, 'search'])->name('search');