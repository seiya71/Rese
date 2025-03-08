@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <h2>testさん</h2>
    <div>
        <h3>予約状況</h3>
        <div>
            <div>
                <p>予約1</p>
                <p>✕</p>
            </div>
            <div>
                <span>Shop</span><span>仙人</span>
            </div>
            <div>
                <span>Date</span><span>2021-04-01</span>
            </div>
            <div>
                <span>Time</span><span>17:00</span>
            </div>
            <div>
                <span>Number</span><span>１人</span>
            </div>
        </div>
    </div>
    <div>
        <h3>お気に入り店舗</h3>
        <div class="shop-card">
            <img src="" alt="店舗画像">
            <h3>仙人</h3>
            <p>#東京</p>
            <p>#寿司</p>
            <button class="btn-login" onclick="location.href='/detail'">詳しくみる</button>
            <p>💛</p>
        </div>
        <div class="shop-card">
            <img src="" alt="店舗画像">
            <h3>仙人</h3>
            <p>#東京</p>
            <p>#寿司</p>
            <button class="btn-login" onclick="location.href='/detail'">詳しくみる</button>
            <p>💛</p>
        </div>
    </div>
@endsection