@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="shop-details">
        <div class="shop-detail">
            <h2 class="shop-name">{{ $shop->shop_name }}</h2>
            <img class="shop-image" src="{{ asset('storage/images/' . $shop->shop_image) }}" alt="{{ $shop->shop_name }}">
            <div class="category">
                <p class="category-item">#{{ $shop->area->area_name }}</p>
                <p class="category-item">#{{ $shop->genre->genre_name }}</p>
            </div>
            <p class="introduction">{{ $shop->introduction }}</p>
        </div>
        <div class="shop-info">
            <div>
                <h2>お知らせメール送信（管理画面）</h2>
                @if (session('status'))
                    <p style="color: green;">{{ session('status') }}</p>
                @endif
                <form action="/admin/notice" method="POST">
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