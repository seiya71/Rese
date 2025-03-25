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

Route::get('/detail/{shopId}', [ShopController::class, 'detail'])->name('detail');

Route::post('register', [UserController::class, 'register'])->name('register');

Route::get('/thanks', [UserController::class, 'thanks'])->name('thanks');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

Route::get('/done/{shopId}', function ($shopId) {
    return view('done', ['shopId' => $shopId]);
})->name('done');

Route::post('/togglelike/{shopId}', [ShopController::class, 'toggleLike'])->name('togglelike');


Route::post('/clear-redirect-session', function () {
    Session::forget('redirect_after_login');
    return response()->json(['status' => 'cleared']);
})->name('clear_redirect_session');

Route::get('/search', [ShopController::class, 'search'])->name('search');

Route::post('/reserve/{shopId}', [ShopController::class, 'reservation'])->name('reservation');

Route::delete('/reservation/{id}', [UserController::class, 'cancel'])->name('reservation.cancel');

Route::put('/reservation/update/{id}', [UserController::class, 'update'])->name('reservation.update');
