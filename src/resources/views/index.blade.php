@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('search')
    <form class="search-form" action="/search" method="GET">
        <select name="area">
            <option value="">All area</option>
            @foreach ($areas as $area)
                <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                    {{ $area['area_name'] }}
                </option>
            @endforeach
        </select>
        <select name="genre">
            <option value="">All genre</option>
            @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                    {{ $genre['genre_name'] }}
                </option>
            @endforeach
        </select>
        <input type="text" name="keyword" placeholder="Search" value="{{ request('keyword') }}">
    </form>
@endsection

@section('content')
    <div>
        @foreach ($shops as $shop)
            <div class="card">
                <div>店舗画像</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $shop->shop_name }}</h5>
                    <p class="card-text"><span>#</span> {{ $shop->area->area_name }}</p>
                    <p class="card-text"><span>#</span> {{ $shop->genre->genre_name }}</p>
                    <form action="{{ route('togglelike', $shop->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="status-img">
                            <img src="{{ asset(in_array($shop->id, $favoriteShopIds) ? 'images/red-heart.svg' : 'images/gray-heart.svg') }}"
                                alt="お気に入り" width="24" height="24">
                        </button>
                    </form>
                    <a href="{{ url('/detail', $shop->id) }}" class="btn btn-outline-primary">詳細を見る</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection