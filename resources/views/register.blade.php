<x-head />
<x-header />

<body>
    <div class="auth-container">
        @guest
        <div class="auth-box">
            <h3 class="auth-title">Регистрация</h3>

            @if(session('success'))
                <div class="profile-success" style="margin-bottom: 20px;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="auth-error" style="margin-bottom: 20px;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('registerform') }}" method="post" enctype="multipart/form-data" class="auth-form">
                @csrf

                <!-- Имя пользователя -->
                <div class="auth-form-group">
                    <label class="auth-label">Имя пользователя</label>
                    <input type="text" name="name" placeholder="Введите имя..." value="{{ old('name') }}" class="auth-input">
                    @error('name')
                        <div class="auth-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="auth-form-group">
                    <label class="auth-label">Email</label>
                    <input type="email" name="email" placeholder="Введите email..." value="{{ old('email') }}" class="auth-input">
                    @error('email')
                        <div class="auth-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Пароль -->
                <div class="auth-form-group">
                    <label class="auth-label">Пароль</label>
                    <input type="password" name="password" placeholder="Введите пароль..." class="auth-input">
                    @error('password')
                        <div class="auth-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Подтверждение пароля -->
                <div class="auth-form-group">
                    <label class="auth-label">Подтверждение пароля</label>
                    <input type="password" name="password_confirmation" placeholder="Повторите пароль..." class="auth-input">
                    @error('password_confirmation')
                        <div class="auth-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Аватар -->
                <div class="auth-form-group">
                    <label class="auth-label">Аватар</label>
                    <input type="file" name="avatar" class="auth-file-input" id="avatarInput">
                    <div class="auth-file-info" id="fileName">Файл не выбран</div>
                    @error('avatar')
                        <div class="auth-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Информация о модерации -->
                <div class="auth-info">
                    <div class="auth-info-icon">📋</div>
                    <div class="auth-info-text">
                        <strong>После отправки заявки:</strong>
                        <ul>
                            <li>Она будет проверена администратором</li>
                            <li>Вы получите результат на email</li>
                            <li>Вы сможете изменить только аватар</li>
                            <li>Обычно проверка занимает до 24 часов</li>
                        </ul>
                    </div>
                </div>

                <p class="auth-text">
                    У вас уже есть аккаунт? <a href="{{ route('auth') }}">Войти</a>
                </p>

                <button type="submit" class="auth-btn">Отправить заявку</button>
            </form>
        </div>
        @endguest

        @auth
            <div class="auth-box">
                <h3 class="auth-title">Вы уже авторизованы</h3>
                <p style="text-align: center; color: #aaa;">
                    Вернитесь на <a href="{{ route('home') }}" style="color: red;">главную</a>
                </p>
            </div>
        @endauth
    </div>

    <style>
        /* Стили для информации о модерации */
        .auth-info {
            display: flex;
            gap: 12px;
            padding: 16px;
            background: rgba(255, 59, 59, 0.08);
            border: 1px solid rgba(255, 59, 59, 0.15);
            border-radius: 8px;
            margin: 10px 0;
        }

        .auth-info-icon {
            font-size: 24px;
            flex-shrink: 0;
        }

        .auth-info-text {
            color: #aaa;
            font-size: 14px;
            line-height: 1.6;
        }

        .auth-info-text strong {
            color: #fff;
            display: block;
            margin-bottom: 4px;
        }

        .auth-info-text ul {
            margin: 4px 0 0 0;
            padding-left: 20px;
        }

        .auth-info-text ul li {
            color: #888;
            font-size: 13px;
        }

        .auth-file-info {
            margin-top: 6px;
            color: #666;
            font-size: 13px;
            padding: 4px 0;
        }

        .auth-file-info.has-file {
            color: #2ecc71;
        }

        /* Кнопка с иконкой */
        .auth-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Адаптивность */
        @media (max-width: 480px) {
            .auth-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .auth-info-text ul {
                text-align: left;
            }
        }
    </style>

    <script>
        // Отображение имени файла
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatarInput');
            const fileName = document.getElementById('fileName');

            if (avatarInput) {
                avatarInput.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        fileName.textContent = this.files[0].name;
                        fileName.classList.add('has-file');
                    } else {
                        fileName.textContent = 'Файл не выбран';
                        fileName.classList.remove('has-file');
                    }
                });
            }
        });
    </script>
</body>
</html>