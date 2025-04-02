@extends('layouts.app')

@section('content')
    <h1>メールを確認してください</h1>
    <p>ご登録ありがとうございます。確認メールを {{ Auth::user()->email }} に送信しました。</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">確認メールを再送する</button>
    </form>
@endsection