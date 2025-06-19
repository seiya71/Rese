@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
    <div class="card">
    <p class="verify-email__text">メールを確認してください</p>
    <p class="verify-email__text">ご登録ありがとうございます。</p>
    <p class="verify-email__text">確認メールを {{ Auth::user()->email }} に送信しました。</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn-email" type="submit">確認メールを再送する</button>
    </form>
    </div>
@endsection