@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    @if (session('status'))
        <div class="alert-success">
            {{ session('status') }}
        </div>
    @endif
    <h2 class="user-name">{{ $owner->name }}さん</h2>
    <div class="user-info">
        <h3 class="info-title">経営店舗</h3>
        <div class="shop-actions">
            <a class="detail-button" href="{{ url('/shopCreate') }}">店舗作成</a>
        </div>
        <div class="shop-list">
            @foreach ($shops as $shop)
                <div class="shop-card">
                    <img class="shop-image" src="{{ asset('storage/images/shop_images/' . $shop->shop_image) }}"
                        alt="{{ $shop->shop_name }}">
                    <div class="shop-info">
                        <h3 class="shop-name">{{ $shop->shop_name }}</h3>
                        <div class="shop-meta">
                            <p class="shop-category">
                                <span>#</span> {{ $shop->area->area_name }}
                            </p>
                            <p class="shop-category">
                                <span>#</span> {{ $shop->genre->genre_name }}
                            </p>
                        </div>
                        <div class="shop-actions">
                            <a class="detail-button" href="{{ url('/shopAdmin', $shop->id) }}">店舗管理画面へ</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection