@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="card">
        <h2 class="reserve-title">ご予約ありがとうございます</h2>
        <button class="btn-back" onclick="location.href='{{ route('detail', $shopId) }}'">戻る</button>
    </div>
@endsection