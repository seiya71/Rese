@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('search')
    <form action="/search" method="GET" class="search-form">
        <select name="region">
            <option value="">All area</option>
            <option value="tokyo" {{ request('region') === 'tokyo' ? 'selected' : '' }}>東京</option>
            <option value="osaka" {{ request('region') === 'osaka' ? 'selected' : '' }}>大阪</option>
        </select>

        <select name="genre">
            <option value="">All genre</option>
            <option value="italian" {{ request('genre') === 'italian' ? 'selected' : '' }}>イタリアン</option>
            <option value="sushi" {{ request('genre') === 'sushi' ? 'selected' : '' }}>寿司</option>
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
                    <a href="/detail" class="btn btn-outline-primary">詳細を見る</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection