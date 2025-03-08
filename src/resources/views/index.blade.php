@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('search')
    <form action="/search" method="GET" class="search-form">
        <!-- 地域の選択ボックス -->
        <select name="region">
            <option value="">All area</option>
            <option value="tokyo" {{ request('region') === 'tokyo' ? 'selected' : '' }}>東京</option>
            <option value="osaka" {{ request('region') === 'osaka' ? 'selected' : '' }}>大阪</option>
            <!-- 他にも地域を追加 -->
        </select>

        <!-- ジャンルの選択ボックス -->
        <select name="genre">
            <option value="">All genre</option>
            <option value="italian" {{ request('genre') === 'italian' ? 'selected' : '' }}>イタリアン</option>
            <option value="sushi" {{ request('genre') === 'sushi' ? 'selected' : '' }}>寿司</option>
            <!-- 他にもジャンルを追加 -->
        </select>
        <!-- 店名（キーワード）で検索 -->
        <input type="text" name="keyword" placeholder="Search" value="{{ request('keyword') }}">
    </form>
@endsection

@section('content')
    <div>
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