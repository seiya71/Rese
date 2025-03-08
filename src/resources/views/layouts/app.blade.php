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
            <label for="menu-toggle" class="menu-button"></label>
            <span class="site-name">Rese</span>
            @yield('search')
        </div>
        <nav class="menu">
            <ul class="menu-list">
                <li class="menu-item"><a href="#">Home</a></li>
                <li class="menu-item"><a href="#">Logout</a></li>
                <li class="menu-item"><a href="#">Mypage</a></li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>