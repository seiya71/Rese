@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="shop-details">
        <div class="detail-left">
            <h2 class="shop-name">{{ $shop->shop_name }}</h2>
            <img class="shop-image" src="{{ asset('images/' . $shop->image) }}" alt="{{ $shop->shop_name }}">
            <div class="category">
                <p class="category-item">#{{ $shop->area->area_name }}</p>
                <p class="category-item">#{{ $shop->genre->genre_name }}</p>
            </div>
            <p class="introduction">{{ $shop->introduction }}</p>
            <div class="user-comment">
                <h5 class="comment-title">利用者のコメント</h5>
                @foreach ($reviews as $review)
                    <div class="comment">
                        <div class="comment-nav">
                            <p class="user-name">{{ $review->user->name }}</p>
                            <p class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                            </p>
                        </div>
                        <div class="content">
                            <p class="content-text">{{ $review->comment }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="comment-edit">
                @if ($canReview)
                    <div class="edit-nav">
                        <h5 class="comment-title">お店へのコメント</h5>
                    </div>
                    <form action="{{ route('detail', $shop->id) }}" method="GET">
                        <div class="star-rating">
                            <p class="rating-title">お店の評価</p>
                            @for ($i = 1; $i <= 5; $i++)
                                <button class="rating-stars" type="submit" name="rating" value="{{ $i }}" style="background:none; border:none; cursor:pointer;">
                                    {{ $i <= $selectedRating ? '★' : '☆' }}
                                </button>
                            @endfor
                        </div>
                    </form>
                    <form class="edit-area" action="{{ route('review', ['shop' => $shop->id]) }}" method="post">
                        @csrf
                        <input type="hidden" name="rating" value="{{ session('selected_rating', 5) }}">
                        <textarea class="text-edit" name="comment" id="comment"></textarea>
                        <button class="comment-button" type="submit">コメントを送信する</button>
                    </form>
                @else
                    <p class="info-message">※レビュー投稿は利用後に可能です。</p>
                @endif
            </div>
        </div>
        <div class="detail-right">
            <div class="reserve">
                <h3 class="reserve-title">予約</h3>
                <form class="reserve-input" action="{{ route('detail', $shop->id) }}" method="GET">
                    <input class="reserve-input__item" type="date" name="date" value="{{ session('temp_reservation.date') }}" onchange="this.form.submit()"
                        required>

                    <select class="reserve-input__item" name="time" onchange="this.form.submit()" required>
                        @for ($hour = 10; $hour < 24; $hour++)
                            @php $time = sprintf('%02d:00', $hour); @endphp
                            <option value="{{ $time }}" {{ session('temp_reservation.time') == $time ? 'selected' : '' }}>
                                {{ $time }}
                            </option>
                        @endfor
                    </select>

                    <select class="reserve-input__item" name="guest_count" onchange="this.form.submit()" required>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ session('temp_reservation.guest_count') == $i ? 'selected' : '' }}>
                                {{ $i }}人
                            </option>
                        @endfor
                    </select>
                </form>
                <div class="reservation-info">
                    <div class="info-row">
                        <div class="label">Shop</div>
                        <div class="value">{{ $shop->shop_name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="label">Date</div>
                        <div class="value">
                            {{ session('temp_reservation.date', '選択してください') }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">Time</div>
                        <div class="value">
                            {{ session('temp_reservation.time', '選択してください') }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">Number</div>
                        <div class="value">
                            {{ session('temp_reservation.guest_count', '選択してください') }}人
                        </div>
                    </div>
                </div>
                <div class="error-box">
                    @error('date')
                        <p>{{ $message }}</p>
                    @enderror
                    @error('time')
                        <p>{{ $message }}</p>
                    @enderror
                    @error('guest_count')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <form class="reserve-submit-form" action="{{ route('reservation', $shop->id) }}" method="POST">
                    @csrf
                    <button class="reserve-button" type="submit">予約する</button>
                </form>
            </div>
        </div>
    </div>
@endsection