@php
    $redirectUrl = session('redirect_after_login');
    session()->forget('redirect_after_login');
@endphp

@if($redirectUrl)
    <form id="postRedirectForm" action="{{ $redirectUrl }}" method="POST">
        @csrf
    </form>

    <meta http-equiv="refresh" content="0;url={{ $redirectUrl }}">
@endif