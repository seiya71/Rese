<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>
<body>
    <header>
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <div class="menu-header">
            <div class="menu-left">
                <label for="menu-toggle" class="menu-button"></label>
                <span class="site-name">Rese</span>
            </div>
            <div class="menu-right">
                @yield('search')
            </div>
        </div>
        <nav class="menu">
            <ul class="menu-list">
                @if (Auth::check())
                    <li class="menu-item"><a class="menu-item__text" href="/">Home</a></li>
                    <li class="menu-item">
                        <form action="/logout" method="post" style="display:inline;">
                            @csrf
                            <button class="logout-button" type="submit">Logout</button>
                        </form>
                    </li>
                    <li class="menu-item"><a class="menu-item__text" href="/mypage">Mypage</a></li>
                @else
                    <li class="menu-item"><a class="menu-item__text" href="/">Home</a></li>
                    <li class="menu-item"><a class="menu-item__text" href="/register">Register</a></li>
                    <li class="menu-item">
                        <a class="menu-item__text" href="{{ route('login', ['redirect' => request()->fullUrl()]) }}">Login</a>
                    </li>
                @endif
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>