<header class="jma_header">
    <!-- Логотип -->
    <a href="{{ route('home') }}" style="display: block;">
        <img class="jma_logo" src="{{ asset('storage/img/other/logo.png') }}" alt="JMA Logo">
    </a>

    <!-- Десктопное меню навигации -->
    <nav class="header-nav desktop-nav">
        <button class="header-btn">РЕЙТИНГ</button>
        <button class="header-btn">ПРЕМИЯ JMA</button>
        <button class="header-btn">ВЫБОР MELO</button>

        <!-- Единый модуль поиска -->
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Поиск..." class="search-input">
            <button type="submit" class="search-btn">Найти</button>
        </form>
    </nav>

    <!-- Правая часть: профиль или кнопки входа (десктоп) -->
    <div class="header-right desktop-auth">
        @if(Auth::check())
            <img class="auth-avatar" onclick="window.location='{{ route('profile') }}'"
                src="{{ auth()->user()->avatar }}" alt="Avatar">
        @else
            <button class="header-btn btn-auth" onclick="window.location='{{ route('auth') }}'">АВТОРИЗАЦИЯ</button>
        @endif
    </div>

</header>