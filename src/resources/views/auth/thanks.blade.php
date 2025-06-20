@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <div class="card">
        <p class="thanks-text">会員登録ありがとうございます</p>
        <button class="btn-login" onclick="location.href='/login'">ログインする</button>
    </div>
@endsection