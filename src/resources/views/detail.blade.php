@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="shop-details">
        <h2>{{ $shop->shop_name }}</h2>
        <p>エリア: {{ $shop->area->area_name }}</p>
        <p>ジャンル: {{ $shop->genre->genre_name }}</p>
        <p>{{ $shop->description }}</p>
        <img src="{{ asset('images/' . $shop->image) }}" alt="{{ $shop->shop_name }}">

        {{-- 即時反映フォーム（変更するたびに更新） --}}
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

        {{-- 予約情報の確認表示 --}}
        <div class="reservation-preview">
            <h3>予約内容の確認</h3>
            <p>日付: {{ session('temp_reservation.date', '選択してください') }}</p>
            <p>時間: {{ session('temp_reservation.time', '選択してください') }}</p>
            <p>人数: {{ session('temp_reservation.guest_count', '選択してください') }}人</p>
        </div>

        {{-- 予約確定フォーム（ボタンを押したときだけ送信） --}}
        <form action="{{ route('reservation', $shop->id) }}" method="POST">
            @csrf
            <button type="submit">予約する</button>
        </form>
    </div>
@endsection