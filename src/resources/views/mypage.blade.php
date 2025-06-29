@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    @if (session('status'))
        <div class="alert-success">
            {{ session('status') }}
        </div>
    @endif
    <h2 class="user-name">{{ $user->name }}さん</h2>
    <div class="user-info">
        <div class="info-left">
            <h3 class="info-title">予約状況</h3>
            @foreach ($reservations as $reservation)
                            <div class="reserve-info">
                                <div class="reserve-info__nav">
                                    <p class="reserve-title">予約{{ $loop->iteration }}</p>
                                    <form class="reserve-cancel" action="{{ route('reservation.cancel', $reservation->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="cancel-button" type="submit">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                                <input class="edit-toggle" type="checkbox" id="edit-toggle-{{ $reservation->id }}" hidden>
                                <label class="edit-button" for="edit-toggle-{{ $reservation->id }}">変更</label>
                                <div class="info-detail">
                                    <div class="info-row">
                                        <div class="label">Shop</div>
                                        <div class="value">{{ $reservation->shop->shop_name }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="label">Date</div>
                                        <div class="value">
                                            {{ Carbon\Carbon::parse($reservation->reservation_datetime)->toDateString() }}
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="label">Time</div>
                                        <div class="value">
                                            {{ Carbon\Carbon::parse($reservation->reservation_datetime)->format('H:i') }}
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="label">Number</div>
                                        <div class="value">
                                            {{ $reservation->guest_count }}人
                                        </div>
                                    </div>
                                </div>
                                <form class="reserve-edit" action="{{ route('reservation.update', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="info-row">
                                        <div class="label">Shop</div>
                                        <div class="value">{{ $reservation->shop->shop_name }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="label">Date</div>
                                        <label class="edit-value">
                                            <input type="date" name="date"
                                                value="{{ \Carbon\Carbon::parse($reservation->reservation_datetime)->toDateString() }}" required>
                                        </label>
                                    </div>
                                    <div class="info-row">
                                        <div class="label">Time</div>
                                        <select class="edit-value" name="time" required>
                                            @for ($hour = 10; $hour < 24; $hour++)
                                                @php $time = sprintf('%02d:00', $hour); @endphp
                                                <option value="{{ $time }}" {{ \Carbon\Carbon::parse($reservation->reservation_datetime)->format('H:i') === $time ? 'selected' : '' }}>
                                                    {{ $time }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="info-row">
                                        <div class="label">Number</div>
                                        <select class="edit-value" name="guest_count" required>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ $reservation->guest_count == $i ? 'selected' : '' }}>
                                                    {{ $i }}人
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="update-button">更新する</button>
                                </form>
                                <input class="qr-toggle" type="checkbox" id="qr-toggle-{{ $reservation->id }}" hidden>
                                <label class="qr-button" for="qr-toggle-{{ $reservation->id }}">QRコードを表示</label>
                                <div class="qr-content">
                                    <div class="qr-image">
                                        <img src="data:image/png;base64,{{ $reservation->qrBase64 }}" alt="QRコード">
                                    </div>
                                </div>
                            </div>
            @endforeach
        </div>
        <div class="info-right">
            <h3 class="info-title">お気に入り店舗</h3>
            <div class="shop-list">
                @foreach ($likeShops as $like)
                    <div class="shop-card">
                        <img class="shop-image" src="{{ asset('storage/images/shop_images/' . $like->shop->shop_image) }}" alt="{{ $like->shop->shop_name }}">

                        <div class="shop-info">
                            <h3 class="shop-name">{{ $like->shop->shop_name }}</h3>
                            <div class="shop-meta">
                                <p class="shop-category">
                                    <span>#</span> {{ $like->shop->area->area_name }}
                                </p>
                                <p class="shop-category">
                                    <span>#</span> {{ $like->shop->genre->genre_name }}
                                </p>
                            </div>
                            <div class="shop-actions">
                                <a class="detail-button" href="{{ url('/detail', $like->shop->id) }}">詳細を見る</a>
                                <form class="favorite-form" action="{{ route('togglelike', $like->shop->id) }}" method="POST">
                                    @csrf
                                    <button class="favorite-button" type="submit">
                                        <img class="favorite-heart" src="{{ asset('images/red-heart.svg') }}" alt="お気に入り解除" width="24" height="24">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection