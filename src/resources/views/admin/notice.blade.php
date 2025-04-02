@extends('layouts.app')

@section('content')
    <h2>お知らせメール送信（管理画面）</h2>

    @if (session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    <form action="/admin/notice" method="POST">
        @csrf
        <div>
            <label>対象ユーザー：</label>
            <select name="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>メッセージ内容：</label>
            <textarea name="message" rows="5" cols="50"></textarea>
        </div>

        <button type="submit">送信</button>
    </form>
@endsection