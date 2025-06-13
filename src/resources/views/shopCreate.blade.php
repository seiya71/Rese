@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
        <h1 class="sell-title">店舗の作成</h1>
        <form class="item-image" action="{{ route('uploadShopImage') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <p class="item-image__title">店舗画像</p>
            <div class="item-image__upload">
                @if (session('shop_image'))
                    <div class="preview-image">
                        <img src="{{ asset('storage/images/shop_images/' . session('shop_image')) }}" alt="店舗画像">
                    </div>
                @endif
                <div class="button-box">
                    <label class="upload-button" for="shop_image">画像を選択する</label>
                    <input class="img-label" type="file" name="shop_image" id="shop_image" accept="image/*"
                        onchange="this.form.submit()">
                </div>
            </div>
        </form>

        <form action="{{ route('shopCreate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="description-label" for="shop_name">店舗名</label>
                <input class="description-input" type="text" id="shop_name" name="shop_name" required>
            </div>

            <div class="info-row">
                <div class="label">エリア</div>
                <select class="update-value" name="area" required>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->area_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="info-row">
                <div class="label">ジャンル</div>
                <select class="update-value" name="genre" required>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->genre_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="description-label" for="description">店舗紹介</label>
                <textarea class="description-textarea" id="description" name="introduction" required></textarea>
            </div>

            <input type="hidden" name="shop_image" value="{{ session('shop_image') }}">

            <button type="submit" class="sell-btn">店舗作成する</button>
        </form>

    </div>
@endsection