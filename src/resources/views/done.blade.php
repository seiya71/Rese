@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="card">
        <p class="reserve-text">ご予約ありがとうございます</p>
        <button class="btn-back" onclick="location.href='{{ route('detail', $shopId) }}'">戻る</button>
    </div>
@endsection