<?php

use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;


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

Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::get('/thanks', 'thanks')->name('thanks');
    Route::get('/login', 'showLoginForm')->name('showLogin');
    Route::post('/login', 'login')->name('login');
    Route::get('/mypage', 'mypage')->name('mypage');
    Route::delete('/reservation/{id}', 'cancel')->name('reservation.cancel');
    Route::put('/reservation/update/{id}', 'update')->name('reservation.update');
});

Route::controller(ShopController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/detail/{shopId}', 'detail')->name('detail');
    Route::post('/togglelike/{shopId}', 'toggleLike')->name('togglelike');
    Route::get('/search', 'search')->name('search');
});

Route::controller(ReservationController::class)->middleware('auth')->group(function () {
    Route::post('/reserve/{shopId}', 'reservation')->name('reservation');
    Route::post('/shops/{shop}/review', 'review')->name('review');
});

Route::controller(PaymentController::class)->group(function () {
    Route::get('/amount/{reservation}', 'amountForm')->name('amount');
    Route::post('/payment/charge', 'charge')->name('payment.charge');
});

Route::controller(OwnerController::class)->middleware('auth')->group(function () {
    Route::get('/owner', 'owner')->name('owner');
    Route::get('/shopAdmin/{shopId}', 'shopAdmin')->name('shopAdmin');
    Route::get('/shopCreate', 'showCreate')->name('showCreate');
    Route::post('/shopCreate', 'shopCreate')->name('shopCreate');
    Route::post('/uploadShopImage', 'uploadShopImage')->name('uploadShopImage');
    Route::put('/shopUpdate/{shopId}', 'shopUpdate')->name('shopUpdate');
    Route::post('/shopAdmin/notice', 'sendNotice')->name('sendNotice');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'admin')->name('admin');
    Route::post('/ownerRegister', 'ownerRegister')->name('ownerRegister');
});

Route::get('/done/{shopId}', function ($shopId) {
    return view('done', ['shopId' => $shopId]);
})->name('done');

Route::post('/clear-redirect-session', function () {
    Session::forget('redirect_after_login');
    return response()->json(['status' => 'cleared']);
})->name('clear_redirect_session');

Route::get('/email/verify', fn() => view('auth.verify-email'))
    ->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/thanks');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '確認メールを再送しました！');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

