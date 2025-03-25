@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <div class="card">
        <h2 class="thanks-title">会員登録ありがとうございます</h2>
        <button class="btn-login" onclick="location.href='/login'">ログインする</button>
    </div>
@endsection