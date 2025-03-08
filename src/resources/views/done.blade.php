@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="card">
        <h2 class="thanks-title">ご予約ありがとうございます</h2>
        <button class="btn-login" onclick="location.href='/login'">戻る</button>
    </div>
@endsection