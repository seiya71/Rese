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
    <h2 class="user-name">{{ $user->name }}さん</h2>
    <div class="user-info">
        <h3 class="info-title">経営店舗</h3>
        <div class="shop-list">
            @foreach ($likeShops as $like)
                <div class="shop-card">
                    <img class="shop-image" src="{{ asset('storage/images/' . $like->shop->shop_image) }}"
                        alt="{{ $like->shop->shop_name }}">
                    <div class="shop-info">
                        <h3 class="shop-name">{{ $like->shop->shop_name }}</h3>
                        <div class="shop-meta">
                            <p class="shop-category">
                                <span>#</span> {{ $like->shop->area->area_name }}
                            </p>
                            <p class="shop-category">
                                <span>#</span> {{ $like->shop->genre->genre_name }}
                            </p>
                        </div>
                        <div class="shop-actions">
                            <a class="detail-button" href="{{ url('/shopAdmin', $like->shop->id) }}">店舗管理画面へ</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection