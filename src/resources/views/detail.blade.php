@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="shop-details">
        <div class="detail-left">
            <h2>{{ $shop->shop_name }}</h2>
            <img src="{{ asset('images/' . $shop->image) }}" alt="{{ $shop->shop_name }}">
            <p>#{{ $shop->area->area_name }}</p>
            <p>#{{ $shop->genre->genre_name }}</p>
            <p>{{ $shop->introduction }}</p>
        </div>
        <div class="detail-right">
            <form action="{{ route('detail', $shop->id) }}" method="GET">
                <input type="date" name="date" value="{{ session('temp_reservation.date') }}" onchange="this.form.submit()"
                    required>

                <select name="time" onchange="this.form.submit()" required>
                    @for ($hour = 10; $hour < 24; $hour++)
                        @php $time = sprintf('%02d:00', $hour); @endphp
                        <option value="{{ $time }}" {{ session('temp_reservation.time') == $time ? 'selected' : '' }}>
                            {{ $time }}
                        </option>
                    @endfor
                </select>

                <select name="guest_count" onchange="this.form.submit()" required>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ session('temp_reservation.guest_count') == $i ? 'selected' : '' }}>
                            {{ $i }}人
                        </option>
                    @endfor
                </select>
            </form>
            <div class="reservation-preview">
                <h3>予約内容の確認</h3>
                <p>日付: {{ session('temp_reservation.date', '選択してください') }}</p>
                <p>時間: {{ session('temp_reservation.time', '選択してください') }}</p>
                <p>人数: {{ session('temp_reservation.guest_count', '選択してください') }}人</p>
            </div>

            <form action="{{ route('reservation', $shop->id) }}" method="POST">
                @csrf
                <button type="submit">予約する</button>
            </form>
        </div>
    </div>
@endsection