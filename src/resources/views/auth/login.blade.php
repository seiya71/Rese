@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="error-box">
        @error('name')
            <p class="error-text">{{ $message }}</p>
        @enderror
        @error('email')
            <p class="error-text">{{ $message }}</p>
        @enderror
        @error('password')
            <p class="error-text">{{ $message }}</p>
        @enderror
    </div>

    <div class="login-box">
        <div class="login-header">
            <p class="login-title">Login</p>
        </div>
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