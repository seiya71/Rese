@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <h2>{{ $user->name }}</h2>
    <div>
        <h3>予約状況</h3>
        <div>
            <div>
                <p>予約1</p>
                <p>✕</p>
            </div>
            <div>
                <span>Shop</span>
                <span>{{ $reservation->shop->shop_name }}</span>
            </div>
            <div>
                <span>Date</span>
                <span>{{ $date }}</span>
            </div>
            <div>
                <span>Time</span>
                <span>{{ $time }}</span>
            </div>
            <div>
                <span>Number</span>
                <span>{{ $reservation->guest_count }}人</span>
            </div>
        </div>
    </div>
    <div>
        <h3>お気に入り店舗</h3>
        @foreach ($likeShops as $like)
            <div>
                <img src="" alt="店舗画像">
                <h3>{{ $like->shop->shop_name }}</h3>
                <span>#</span>
                <span>{{ $like->shop->area->area_name }}</span>
                <span>#</span>
                <span>{{ $like->shop->genre->genre_name }}</span>
                <a href="{{ url('/detail', $like->shop->id) }}" class="btn btn-outline-primary">詳細を見る</a>
            </div>
        @endforeach
    </div>
@endsection