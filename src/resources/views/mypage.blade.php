@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <h2>{{ $user->name }}</h2>
    <div>
        <h3>予約状況</h3>
        <div>
        @foreach ($reservations as $reservation)
            <div>
                <div>
                    <p>予約{{ $loop->iteration }}</p>
                    <form action="{{ route('reservation.cancel', $reservation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">
                            ✕
                        </button>
                    </form>
                </div>
                <div>
                    <span>Shop</span>
                    <span>{{ $reservation->shop->shop_name }}</span>
                </div>
                <div>
                    <span>Date</span>
                    <span>
                        {{ Carbon\Carbon::parse($reservation->reservation_datetime)->toDateString() }}
                    </span>
                </div>
                <div>
                    <span>Time</span>
                    <span>
                        {{ Carbon\Carbon::parse($reservation->reservation_datetime)->format('H:i') }}
                    </span>
                </div>
                <div>
                    <span>Number</span>
                    <span>{{ $reservation->guest_count }}人</span>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        <h3>お気に入り店舗</h3>
        @foreach ($likeShops as $like)
            <div>
                <img src="" alt="店舗画像">
                <h3>{{ $like->shop->shop_name }}</h3>
                <span>#</span>
                <span>{{ $like->shop->area->area_name }}</span>
                <span>#</span>
                <span>{{ $like->shop->genre->genre_name }}</span>
                <form action="{{ route('togglelike', $like->shop->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="status-img">
                        <img src="{{ asset('images/red-heart.svg') }}" alt="お気に入り解除" width="24" height="24">
                    </button>
                </form>
                <a href="{{ url('/detail', $like->shop->id) }}" class="btn btn-outline-primary">詳細を見る</a>
            </div>
        @endforeach
    </div>
@endsection