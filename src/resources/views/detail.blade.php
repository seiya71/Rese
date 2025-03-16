@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div>
        <a href="">＜</a>
        <h3>{{ $shop->shop_name }}</h3>
        <img src="" alt="店舗画像">
        <p class="card-text">
            <span>#</span>
            {{ $shop->area->area_name }}
        </p>
        <p class="card-text">
            <span>#</span>
            {{ $shop->genre->genre_name }}
        </p>
        <div>
            {{ $shop->introduction }}
        </div>
    </div>
    <div>
        <form action="{{ url('/reserve', $shop->id) }}" method="post">
            @csrf
            <input type="date" name="date">
            <select name="time">
                @for ($hour = 10; $hour < 24; $hour++)
                                @php
    $time = sprintf('%02d:00', $hour);
                                @endphp
                                <option value="{{ $time }}">{{ $time }}</option>
                @endfor
            </select>
            <select name="guest_count">
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }}人</option>
                @endfor
            </select>
            <div>
                <div>
                    <span>Shop</span><span>仙人</span>
                </div>
                <div>
                    <span>Date</span><span>2021-04-01</span>
                </div>
                <div>
                    <span>Time</span><span>17:00</span>
                </div>
                <div>
                    <span>Number</span><span>１人</span>
                </div>
            </div>
            <button>予約する</button>
        </form>
    </div>
@endsection