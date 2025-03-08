@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div>
        <a href="">＜</a>
        <h3>仙人</h3>
        <img src="" alt="店舗画像">
        <p>#東京</p>
        <p>#寿司</p>
        <div>
            料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追求したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。
        </div>
    </div>
    <div>
        <form action="">
            <input type="date">
            <select name="time">
                <option value="17:00">17:00</option>
                <option value="18:00">18:00</option>
                <option value="19:00">19:00</option>
                <option value="20:00">20:00</option>
                <option value="21:00">21:00</option>
                <option value="22:00">22:00</option>
                <option value="23:00">23:00</option>
            </select>
            <select name="guest">
                <option value="1">１人</option>
                <option value="2">２人</option>
                <option value="3">３人</option>
                <option value="4">４人</option>
                <option value="5">５人</option>
                <option value="6">６人</option>
                <option value="7">７人</option>
                <option value="8">８人</option>
                <option value="9">９人</option>
                <option value="10">１０人</option>
            </select>
            <div>
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
            <button>予約する</button>
        </form>
    </div>
@endsection