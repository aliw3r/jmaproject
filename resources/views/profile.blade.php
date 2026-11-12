<x-head />
<x-header />

<body>
    @if(Auth::check() && Auth::user()->role == 'admin')
    <div class="profile-menu">
        <div class="punkt-menu1">
            <form action="{{ route('admin.pending-users') }}">
                @csrf
                <button type="submit" class="button-menu">Управление пользователями</button>
            </form>
        </div>
        <div class="punkt-menu1">
            <form action="{{ route('admin.avatar-requests') }}">
                @csrf
                <button type="submit" class="button-menu">Управление аватарками</button>
            </form>
        </div>
        <div class="punkt-menu">
            <form action="{{ route('home') }}">
                @csrf
                <button type="submit" class="button-menu">Жалобы</button>
            </form>
        </div>
        <div class="punkt-menu1">
            <form action="{{ route('ArtistAdd') }}">
                @csrf
                <button type="submit" class="button-menu">Добавить артиста</button>
            </form>
        </div>
        <div class="punkt-menu1">
            <form action="{{ route('AlbumAdd') }}">
                @csrf
                <button type="submit" class="button-menu">Добавить альбом</button>
            </form>
        </div>
        <div class="punkt-menu">
            <form action="{{ route('SongAdd') }}">
                @csrf
                <button type="submit" class="button-menu">Добавить трек</button>
            </form>
        </div>
        <div class="punkt-menu">
            <form action="{{ route('home') }}">
                @csrf
                <button type="submit" class="button-menu">Ваши оценки</button>
            </form>
        </div>
        <div class="punkt-menu">
            <form action="{{ route('logout') }}" method="GET">
                @csrf
                <button type="submit" class="button-menu">Выход</button>
            </form>
        </div>
    </div>
    <div style="max-width: 800px; margin: 50px auto 50px; padding: 20px;">
        <h1 class="text-center">Приветствую, {{auth()->user()->name}}.</h1>

        @if(session('success'))
        <div style="text-align:center; color: #00ff88; background: rgba(0,255,136,0.1); padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(0,255,136,0.3);">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="text-align:center; color: #ff4444; background: rgba(255,68,68,0.1); padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255,68,68,0.3);">
            {{ session('error') }}
        </div>
        @endif

        <!-- Информация о пользователе -->
        <div style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; backdrop-filter: blur(10px); margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                <!-- Аватар -->
                <div style="text-align: center;">
                    <div style="width: 150px; height: 150px; border-radius: 10%; overflow: hidden; border: 3px solid red; margin: 0 auto;">
                        @if($user->avatar && $user->avatar !== 'avatars/default.png')
                        <img src="{{ $user->avatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #fe4f4f, #fe0000); display: flex; align-items: center; justify-content: center; font-size: 3em; color: white;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        @endif
                    </div>

                    <!-- Статус запроса -->
                    @if($pendingRequest)
                    <div style="margin-top: 10px; padding: 8px 15px; background: rgba(255,215,0,0.2); border-radius: 20px; border: 1px solid rgba(255,215,0,0.3); display: inline-block;">
                        <span style="color: gold; font-size: 0.85em;">⏳ Ожидает подтверждения</span>
                    </div>
                    @endif
                </div>

                <!-- Данные пользователя -->
                <div style="flex: 1;">
                    <h2 style="color: white; margin-bottom: 5px;">{{ $user->name }}</h2>
                    <p style="color: #aaa; margin-bottom: 5px;">{{ $user->email }}</p>
                    <p style="color: #888; font-size: 0.9em;">
                        Роль: <span style="color: {{ $user->isAdmin() ? '#ffd700' : '#4facfe' }};">
                            {{ $user->isAdmin() ? '👑 Администратор' : '👤 Пользователь' }}
                        </span>
                    </p>
                    <p style="color: #888; font-size: 0.9em;">
                        Статус:
                        @if($user->isActive())
                        <span style="color: #00ff88;">✅ Активен</span>
                        @else
                        <span style="color: #ff4444;">⛔ Ожидает активации</span>
                        @endif
                    </p>
                    @if($user->approved_at)
                    <p style="color: #888; font-size: 0.8em;">
                        Дата активации: {{ $user->approved_at }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Форма смены аватарки -->
        <div style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; backdrop-filter: blur(10px);">
            <h3 style="color: white; margin-bottom: 20px;">Смена аватарки</h3>

            @if($pendingRequest)
            <!-- Если есть ожидающий запрос -->
            <div style="background: rgba(255,215,0,0.05); padding: 20px; border-radius: 10px; border: 1px solid rgba(255,215,0,0.2);">
                <p style="color: gold;">⏳ Ваш запрос на смену аватарки ожидает рассмотрения администратором.</p>
                <div style="display: flex; gap: 10px; margin-top: 15px;">
                    <form action="{{ route('avatar.cancel', $pendingRequest->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Отменить запрос на смену аватарки?')"
                            style="padding: 8px 20px; border-radius: 8px; background: rgba(255,68,68,0.2); color: #ff4444; border: 1px solid rgba(255,68,68,0.3); cursor: pointer;">
                            ✕ Отменить запрос
                        </button>
                    </form>
                </div>
            </div>
            @else
            <!-- Форма загрузки новой аватарки -->
            <form action="{{ route('avatar.request') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 15px;">
                    <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Выберите новое фото</label>
                    <input type="file" name="avatar" accept="image/*" required
                        style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; box-sizing: border-box;">
                    <div style="color: #888; font-size: 0.8em; margin-top: 5px;">
                        Рекомендуемый размер: 500x500px, формат: JPG, PNG, GIF. Макс. размер: 2MB
                    </div>
                    @error('avatar')
                    <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                    style="width: 100%; padding: 14px; border-radius: 8px; background: red; color: white; border: none; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: transform 0.2s;"
                    onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    📤 Отправить запрос на смену аватарки
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Модальное окно для предпросмотра -->
    <div id="avatarModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; justify-content: center; align-items: center;">
        <div style="position: relative; max-width: 500px; padding: 20px; background: #1a1a1a; border-radius: 15px;">
            <button onclick="closeModal()" style="position: absolute; top: 10px; right: 15px; background: none; border: none; color: white; font-size: 2em; cursor: pointer;">✕</button>
            <img id="modalImage" src="" alt="Preview" style="width: 100%; border-radius: 10px;">
            <p style="color: #aaa; text-align: center; margin-top: 10px;">Новая аватарка (ожидает подтверждения)</p>
        </div>
    </div>


    @endif
    @if(Auth::check() && Auth::user()->role == 'client')
    <div class="profile-menu">
        <div class="punkt-menu">
            <form action="{{ route('home') }}">
                @csrf
                <button type="submit" class="button-menu">Избранное</button>
            </form>
        </div>
        <div class="punkt-menu1">
            <form action="{{ route('home') }}">
                @csrf
                <button type="submit" class="button-menu1">Редактировать профиль</button>
            </form>
        </div>
        <div class="punkt-menu">
            <form action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="button-menu">Выход</button>
            </form>
        </div>
    </div>
    <div style="max-width: 800px; margin: 120px auto 50px; padding: 20px;">
        <h1 style="text-align: center; color: white; margin-bottom: 30px;">Мой профиль</h1>

        @if(session('success'))
        <div style="text-align:center; color: #00ff88; background: rgba(0,255,136,0.1); padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(0,255,136,0.3);">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <!-- Уведомление об отклонении запроса -->
        @if($rejectedRequest && $rejectedRequest->rejection_reason)
        <div style="background: rgba(255,68,68,0.1); padding: 20px; border-radius: 10px; border: 1px solid rgba(255,68,68,0.3); margin-bottom: 20px;">
            <div style="display: flex; align-items: flex-start; gap: 15px;">
                <div style="font-size: 2em;">❌</div>
                <div style="flex: 1;">
                    <h4 style="color: #ff4444; margin: 0 0 5px 0;">Запрос на смену аватарки отклонен</h4>
                    <p style="color: #ff8888; margin: 5px 0;">
                        <strong>Причина:</strong> {{ $rejectedRequest->rejection_reason }}
                    </p>
                    <p style="color: #888; font-size: 0.85em; margin: 5px 0;">
                        Дата отклонения: {{ $rejectedRequest->reviewed_at->format('d.m.Y H:i') }}
                    </p>
                    <form action="{{ route('avatar.notification.read') }}" method="POST" style="margin-top: 10px;">
                        @csrf
                        <button type="submit"
                            style="padding: 6px 20px; border-radius: 6px; background: rgba(255,255,255,0.1); color: #aaa; border: 1px solid rgba(255,255,255,0.2); cursor: pointer; font-size: 0.9em;">
                            Понятно
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endif

        <!-- Информация о пользователе -->
        <div style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; backdrop-filter: blur(10px); margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                <!-- Аватар -->
                <div style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden; border: 3px solid #4facfe; margin: 0 auto;">
                    @if($user->avatar && $user->avatar !== '/storage/default-avatar.png')
                    <img src="{{ $user->avatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #4facfe, #00f2fe); display: flex; align-items: center; justify-content: center; font-size: 3em; color: white;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    @endif
                </div>

                <!-- Статус запроса -->
                @if($pendingRequest)
                <div style="margin-top: 10px; padding: 8px 15px; background: rgba(255,215,0,0.2); border-radius: 20px; border: 1px solid rgba(255,215,0,0.3); display: inline-block;">
                    <span style="color: gold; font-size: 0.85em;">⏳ Ожидает подтверждения</span>
                </div>
                @endif
            </div>

            <!-- Данные пользователя -->
            <div style="flex: 1;">
                <h2 style="color: white; margin-bottom: 5px;">{{ $user->name }}</h2>
                <p style="color: #aaa; margin-bottom: 5px;">{{ $user->email }}</p>
                <p style="color: #888; font-size: 0.9em;">
                    Роль: <span style="color: {{ $user->isAdmin() ? '#ffd700' : '#4facfe' }};">
                        {{ $user->isAdmin() ? '👑 Администратор' : '👤 Пользователь' }}
                    </span>
                </p>
                <p style="color: #888; font-size: 0.9em;">
                    Статус:
                    @if($user->isActive())
                    <span style="color: #00ff88;">✅ Активен</span>
                    @else
                    <span style="color: #ff4444;">⛔ Не активен</span>
                    @endif
                </p>
                @if($user->approved_at)
                <p style="color: #888; font-size: 0.8em;">
                    Дата активации: {{ $user->approved_at }}
                </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Форма смены аватарки -->
    <div style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; backdrop-filter: blur(10px);">
        <h3 style="color: white; margin-bottom: 20px;">Смена аватарки</h3>

        @if($pendingRequest)
        <!-- Если есть ожидающий запрос -->
        <div style="background: rgba(255,215,0,0.05); padding: 20px; border-radius: 10px; border: 1px solid rgba(255,215,0,0.2);">
            <p style="color: gold;">⏳ Ваш запрос на смену аватарки ожидает рассмотрения администратором.</p>
            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <button onclick="previewAvatar('/storage/{{ $pendingRequest->new_avatar }}')"
                    style="padding: 8px 20px; border-radius: 8px; background: rgba(79,172,254,0.2); color: #4facfe; border: 1px solid rgba(79,172,254,0.3); cursor: pointer;">
                    👁️ Посмотреть новую аватарку
                </button>
                <form action="{{ route('avatar.cancel', $pendingRequest->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('Отменить запрос на смену аватарки?')"
                        style="padding: 8px 20px; border-radius: 8px; background: rgba(255,68,68,0.2); color: #ff4444; border: 1px solid rgba(255,68,68,0.3); cursor: pointer;">
                        ✕ Отменить запрос
                    </button>
                </form>
            </div>
        </div>
        @else
        <!-- Форма загрузки новой аватарки -->
        <form action="{{ route('avatar.request') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Выберите новое фото</label>
                <input type="file" name="avatar" accept="image/*" required
                    style="width: 100%; padding: 12px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; box-sizing: border-box;">
                <div style="color: #888; font-size: 0.8em; margin-top: 5px;">
                    Рекомендуемый размер: 500x500px, формат: JPG, PNG, GIF. Макс. размер: 2MB
                </div>
                @error('avatar')
                <div style="color: #ff4444; font-size: 0.85em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit"
                style="width: 100%; padding: 14px; border-radius: 8px; background: linear-gradient(135deg, #4facfe, #00f2fe); color: white; border: none; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                📤 Отправить запрос на смену аватарки
            </button>
        </form>
        @endif
    </div>
    </div>

    <!-- Модальное окно для предпросмотра -->
    <div id="avatarModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; justify-content: center; align-items: center;">
        <div style="position: relative; max-width: 500px; padding: 20px; background: #1a1a1a; border-radius: 15px;">
            <button onclick="closeModal()" style="position: absolute; top: 10px; right: 15px; background: none; border: none; color: white; font-size: 2em; cursor: pointer;">✕</button>
            <img id="modalImage" src="" alt="Preview" style="width: 100%; border-radius: 10px;">
            <p style="color: #aaa; text-align: center; margin-top: 10px;">Новая аватарка (ожидает подтверждения)</p>
        </div>
    </div>

    <script>
        function previewAvatar(url) {
            document.getElementById('modalImage').src = url;
            document.getElementById('avatarModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('avatarModal').style.display = 'none';
        }

        // Закрытие по клику вне модального окна
        document.getElementById('avatarModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Закрытие по ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
    @endif
    @guest
    <form>
        @csrf
        <h2 style="margin-top: 30px; margin-left: 40px">Вы не авторизованы! Авторизуйтесь <a href="{{ route ('auth') }}">здесь.</a></h2>
        @endguest
        <x-scripts />
    </form>
</body>

</html>