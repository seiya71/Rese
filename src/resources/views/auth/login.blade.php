@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    @error('name')
        <p>{{ $message }}</p>
    @enderror
    @error('email')
        <p>{{ $message }}</p>
    @enderror
    @error('password')
        <p>{{ $message }}</p>
    @enderror

    <div class="login-box">
        <h2 class="login-title">Login</h2>
        <div class="card-body">
            <form class="login-form" action="/login" method="post">
                @csrf
                <input type="hidden" name="redirect" value="{{ session('redirect_after_login') }}">
                <div class="login-form__group">
                    <img class="icon-img" src="../images/email.png" alt="Email Icon">
                    <div class="input-wrapper">
                        <input class="login-form__input" type="email" id="email" name="email" placeholder="Email"
                            value="{{ old('email') }}" />
                    </div>
                </div>
                <div class="login-form__group">
                    <img class="icon-img" src="../images/password.png" alt="Password Icon">
                    <div class="input-wrapper">
                        <input class="login-form__input" type="password" id="password" name="password"
                            placeholder="Password" />
                    </div>
                </div>
                <button class="login-button" type="submit">ログイン</button>
            </form>
        </div>
    </div>
@endsection

{{-- ログイン成功後のリダイレクト処理 --}}
@if(session()->has('redirect_after_login'))
    @include('auth.post_redirect')
@endif