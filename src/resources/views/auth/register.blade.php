@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="error-box">
        @error('name')
            <p>{{ $message }}</p>
        @enderror
        @error('email')
            <p>{{ $message }}</p>
        @enderror
        @error('password')
            <p>{{ $message }}</p>
        @enderror
    </div>
    <div class="register-box">
        <h2 class="register-title">Registration</h2>
        <div class="card-body">
            <form class="register-form" action="/register" method="post">
                @csrf
                <div class="register-form__group">
                    <img class="icon-img" src="../images/user.png" alt="User Icon">
                    <div class="input-wrapper">
                        <input class="register-form__input" type="text" id="name" name="name" placeholder="Username"
                            value="{{ old('name') }}" />
                    </div>
                </div>
                <div class="register-form__group">
                    <img class="icon-img" src="../images/email.png" alt="Email Icon">
                    <div class="input-wrapper">
                        <input class="register-form__input" type="email" id="email" name="email" placeholder="Email"
                            value="{{ old('email') }}" />
                    </div>
                </div>
                <div class="register-form__group">
                    <img class="icon-img" src="../images/password.png" alt="Password Icon">
                    <div class="input-wrapper">
                        <input class="register-form__input" type="password" id="password" name="password" placeholder="Password" />
                    </div>
                </div>
                <button class="register-button" type="submit">登録</button>
            </form>
        </div>
    </div>
@endsection