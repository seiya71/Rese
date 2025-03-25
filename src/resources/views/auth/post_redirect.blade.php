@if(session()->has('redirect_after_login'))
    <form id="postRedirectForm" action="{{ session('redirect_after_login') }}" method="POST">
        @csrf
    </form>
    @php
        session()->forget('redirect_after_login');
    @endphp

    <meta http-equiv="refresh" content="0;url={{ session('redirect_after_login') }}">
@endif