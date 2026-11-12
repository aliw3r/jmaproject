<header class="jma_header">
    <!-- Логотип -->
    <a href="{{ route('home') }}" style="display: block;">
        <img class="jma_logo" src="{{ asset('storage/img/other/logo.png') }}" alt="JMA Logo">
    </a>

    <!-- Кнопка ПРОФИЛЬ (ведёт на авторизацию или профиль) -->
    <div class="mobile-profile-btn-wrapper">
        @if(Auth::check() && Auth::user()->role == 'client')
            <a href="{{ route('profile') }}" class="mobile-profile-btn">
                <img class="auth-avatar" src="{{ auth()->user()->avatar }}" alt="Avatar">
            </a>
        @else
            <a href="{{ route('login') }}" class="mobile-profile-btn">ПРОФИЛЬ</a>
        @endif
    </div>

    <!-- Кнопка МЕНЮ (открывает полноэкранное меню) -->
    <button class="mobile-menu-toggle" aria-label="Открыть меню">МЕНЮ</button>
</header>

<!-- Полноэкранное мобильное меню (скрыто на десктопе) -->
<div class="mobile-full-menu" id="mobileFullMenu">
    <!-- Кнопка закрытия -->
    <button class="mobile-menu-close" aria-label="Закрыть меню">&times;</button>

    <!-- Пункты навигации -->
    <nav class="mobile-nav-links">
        <a href="{{ route('rating') }}" class="mobile-nav-item">РЕЙТИНГ</a>
        <a href="{{ route('jma-award') }}" class="mobile-nav-item">ПРЕМИЯ JMA</a>
        <a href="{{ route('melo-choice') }}" class="mobile-nav-item">ВЫБОР MELO</a>
    </nav>

    <!-- Поиск внутри меню -->
    <form action="{{ route('search') }}" method="GET" class="mobile-search-form">
        <input type="text" name="q" placeholder="Поиск треков..." class="mobile-search-input">
        <button type="submit" class="mobile-search-btn">Найти</button>
    </form>

    <!-- Авторизация/регистрация -->
    <div class="mobile-auth-actions">
        @if(Auth::check() && Auth::user()->role == 'client')
            <a href="{{ route('profile') }}" class="mobile-auth-link">Профиль</a>
        @else
            <a href="{{ route('login') }}" class="mobile-auth-link">АВТОРИЗАЦИЯ</a>
            <a href="{{ route('register') }}" class="mobile-auth-link">РЕГИСТРАЦИЯ</a>
        @endif
    </div>
</div>

<!-- Заголовок «Недавние релизы» (как и раньше — отдельно от хедера) -->
<div class="glav-nadpis">
    <h2>Недавние релизы</h2>
</div>
