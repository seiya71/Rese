@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    < class="sell-container">
        <h1 class="sell-title">店舗の作成</h1>
        <form class="item-image" action="{{ route('uploadItemImage') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <p class="item-image__title">店舗画像</p>
            <div class="item-image__upload">
                @if (session('item_image'))
                    <div class="preview-image">
                        <img src="{{ asset('storage/' . session('item_image')) }}" alt="商品画像">
                    </div>
                @endif
                <div class="button-box">
                    <label class="upload-button" for="item_image">画像を選択する</label>
                    <input class="img-label" type="file" name="item_image" id="item_image" accept="image/*"
                        onchange="this.form.submit()">
                </div>
            </div>
        </form>
        <form action="{{ route('sell') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="description-label" for="item-name">店舗名</label>
                <input class="description-input" type="text" id="item-name" name="item_name" required>
            </div>
            <div class="item-condition">
                <p class="item-condition__title">エリア</p>
                <select class="item-condition__select" name="condition" id="condition">
                    <option class="select-value" value="選択してください">選択してください</option>
                    <option class="select-value" value="良好">良好</option>
                    <option class="select-value" value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option class="select-value" value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option class="select-value" value="状態が悪い">状態が悪い</option>
                </select>
            </div>
            <div class="item-condition">
                <p class="item-condition__title">ジャンル</p>
                <select class="item-condition__select" name="condition" id="condition">
                    <option class="select-value" value="選択してください">選択してください</option>
                    <option class="select-value" value="良好">良好</option>
                    <option class="select-value" value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option class="select-value" value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option class="select-value" value="状態が悪い">状態が悪い</option>
                </select>
            </div>
            <div class="form-group">
                <label class="description-label" for="description">商品の説明</label>
                <textarea class="description-textarea" id="description" name="description" required></textarea>
            </div>
            <input type="hidden" name="item_image" value="{{ session('item_image') }}">
            <button type="submit" class="sell-btn">店舗作成する</button>
        </form>
    </div>
@endsection