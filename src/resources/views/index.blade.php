@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/index.css') }}">
@endsection

@section('search')
    <form class="search-form" action="/search" method="GET">
        <div class="search-row">
            <div class="search-select">
                <select name="area" class="search-dropdown">
                    <option value="">All area</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                            {{ $area['area_name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="search-select">
                <select name="genre" class="search-dropdown">
                    <option value="">All genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre['genre_name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="search-input-container">
            <input type="text" name="keyword" class="search-input" placeholder="Search" value="{{ request('keyword') }}">
        </div>
    </form>
@endsection


@section('content')
    <div class="shop-list">
        @foreach ($shops as $shop)
            <div class="shop-card">
                <div class="shop-image">
                    <img src="{{ asset('storage/images/' . $shop->shop_image) }}" alt="{{ $shop->shop_name }}">
                </div>
                <div class="shop-info">
                    <h5 class="shop-name">{{ $shop->shop_name }}</h5>
                    <div class="shop-meta">
                        <p class="shop-category"><span>#</span> {{ $shop->area->area_name }}</p>
                        <p class="shop-category"><span>#</span> {{ $shop->genre->genre_name }}</p>
                    </div>
                    <div class="shop-actions">
                        <a class="detail-button" href="{{ url('/detail', $shop->id) }}">詳細を見る</a>
                        <form class="favorite-form" action="{{ route('togglelike', $shop->id) }}" method="POST">
                            @csrf
                            <button class="favorite-button" type="submit">
                                <img class="favorite-heart" src="{{ asset(in_array($shop->id, $favoriteShopIds) ? 'images/red-heart.svg' : 'images/gray-heart.svg') }}"
                                    alt="お気に入り" width="32" height="32">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection