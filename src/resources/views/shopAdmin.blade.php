@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shopAdmin.css') }}">
@endsection

@section('content')
    <div class="shopAdmin-container">
        <div class="shop-detail">
            <div class="detail-header">
                <div class="header-item">
                    <a href="/owner">＜</a>
                    <h2 class="shop-name">{{ $shop->shop_name }}</h2>
                </div>
            </div>
            <img class="shop-image" src="{{ asset('storage/images/shop_images/' . $shop->shop_image) }}"
                alt="{{ $shop->shop_name }}">
            <div class="category">
                <p class="category-item">#{{ $shop->area->area_name }}</p>
                <p class="category-item">#{{ $shop->genre->genre_name }}</p>
            </div>
            <p class="introduction">{{ $shop->introduction }}</p>
            <div class="edit-section">
            <input class="update-toggle" type="checkbox" id="update-toggle"
            {{ session('update_open') ? 'checked' : '' }} hidden>
                <label class="update-button" for="update-toggle">変更</label>
                <div class="edit-mode">
                    @if (session('shop_image'))
                        <div class="preview-image">
                            <img src="{{ asset('storage/images/shop_images/' . session('shop_image')) }}" alt="店舗画像">
                        </div>
                    @else
                        <div class="preview-image">
                            <img src="{{ asset('storage/images/shop_images/' . $shop->shop_image) }}" alt="店舗画像">
                        </div>
                    @endif
                    <form class="edit-image" action="{{ route('uploadShopImage') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="edit-image__upload">
                            <label class="upload-button" for="shop_image">画像を選択する</label>
                            <input type="file" name="shop_image" id="shop_image" accept="image/*"
                                onchange="this.form.submit()">
                        </div>
                    </form>
                    <form class="update-edit" action="{{ route('shopUpdate', $shop->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="info-row">
                            <div class="label">店舗名</div>
                            <label class="update-value">
                                <input type="text" name="shop_name" value="{{ $shop->shop_name }}" required>
                            </label>
                        </div>
                        <div class="info-row">
                            <div class="label">エリア</div>
                            <select class="update-value" name="area" required>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ $area->id === $shop->area_id ? 'selected' : '' }}>
                                        {{ $area->area_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="info-row">
                            <div class="label">ジャンル</div>
                            <select class="update-value" name="genre" required>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ $genre->id === $shop->genre_id ? 'selected' : '' }}>
                                        {{ $genre->genre_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <label class="introduction" for="introduction">店舗紹介</label>
                        <textarea class="introduction-textarea" id="introduction" name="introduction"
                            required>{{ $shop->introduction }}</textarea>
                        <button type="submit" class="update-button">更新する</button>
                    </form>
                </div>
            </div>
            <div class="shop-info">
                <div>
                    <h2>お知らせメール送信（管理画面）</h2>
                    @if (session('status'))
                        <p style="color: green;">{{ session('status') }}</p>
                    @endif
                    <form action="/shopAdmin/notice" method="POST">
                        @csrf
                        <div>
                            <label>対象ユーザー：</label>
                            <select name="user_id">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>メッセージ内容：</label>
                            <textarea name="message" rows="5" cols="50"></textarea>
                        </div>
                        <button type="submit">送信</button>
                    </form>
                </div>
                <div class="reserve">
                    <h3 class="reserve-title">予約状況</h3>
                    <div class="reservation-info">
                        <div class="info-row">
                            <div class="label">User</div>
                            <div class="value">{{ $shop->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="label">Date</div>
                            <div class="value">
                                {{ session('temp_reservation.date') }}
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="label">Time</div>
                            <div class="value">
                                {{ session('temp_reservation.time') }}
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="label">Number</div>
                            <div class="value">
                                {{ session('temp_reservation.guest_count') }}人
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection