<x-head />
<x-header />

<body>
    <div class="auth-container">
        @guest
        <div class="auth-box">
            <h3 class="auth-title">Авторизация</h3>
            
            <form action="{{ Route('authform') }}" method="post" enctype="multipart/form-data" class="auth-form">
                @csrf

                <div class="auth-form-group">
                    <label class="auth-label">Имя пользователя</label>
                    <input type="text" name="name" placeholder="Введите имя..." value="{{ old('name') }}" class="auth-input">
                    @error('name')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-form-group">
                    <label class="auth-label">Пароль</label>
                    <input type="password" name="password" placeholder="Введите пароль..." value="{{ old('password') }}" class="auth-input">
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <p class="auth-text">
                    Ещё нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
                </p>

                <button type="submit" class="auth-btn">Войти</button>
            </form>
        </div>
        @endguest
        @auth
        <h3 class="auth-title">Вы уже авторизованы, вернитесь на <a href="{{ route('home') }}">главную</a>.</h3>
        @endauth
    </div>
</body>
</html>