<x-head />
<x-header />

<body>
    <div style="max-width: 900px; margin: 120px auto 50px; padding: 20px;">
        <h1 style="text-align: center; color: white; margin-bottom: 30px;">Управление запросами на смену аватарки</h1>

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

        @if($requests->isEmpty())
        <div style="text-align: center; color: #888; padding: 50px 0; background: rgba(255,255,255,0.05); border-radius: 15px;">
            <p style="font-size: 1.2em;">📭 Нет ожидающих запросов на смену аватарки</p>
        </div>
        @else
        @foreach($requests as $request)
        <div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 15px; margin-bottom: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                <!-- Старый аватар -->
                <div style="text-align: center;">
                    <div style="font-size: 0.8em; color: #888; margin-bottom: 5px;">Старый</div>
                    <div style="width: 130px; height: 130px; border-radius: 10%; overflow: hidden; border: 2px solid #ff4444;">
                        @if($request->old_avatar)
                        <img src="{{ $request->old_avatar }}" alt="Old" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                        <div style="width: 100%; height: 100%; background: #333; display: flex; align-items: center; justify-content: center; color: #888; font-size: 2em;">
                            ?
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Стрелка -->
                <div style="font-size: 2em; color: #aaa; padding: 0 10px;">→</div>

                <!-- Новый аватар -->
                <div style="text-align: center; min-width: 100px;">
                    <div style="font-size: 0.8em; color: #888; margin-bottom: 5px;">Новый</div>
                    <div style="width: 130px; height: 130px; border-radius: 10%; overflow: hidden; border: 3px solid #00ff88; margin: 0 auto;">
                        @if($request->new_avatar)
                        <img src="/storage/{{ $request->new_avatar }}" alt="New avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #00ff88, #00cc66); display: flex; align-items: center; justify-content: center; color: white; font-size: 2em; font-weight: bold;">
                            ?
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Информация о пользователе -->
                <div style="flex: 1; min-width: 200px;">
                    <div style="color: white; font-weight: bold; font-size: 1.1em;">{{ $request->user->name }}</div>
                    <div style="color: #aaa; font-size: 0.9em;">{{ $request->user->email }}</div>
                    <div style="color: #888; font-size: 0.8em; margin-top: 5px;">
                        🕐 Запрошено: {{ $request->created_at->format('d.m.Y H:i') }}
                    </div>
                    <div style="color: #888; font-size: 0.8em;">
                        📅 {{ $request->created_at->diffForHumans() }}
                    </div>
                </div>

                <!-- Действия -->
                <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    <!-- Кнопка одобрить -->
                    <form action="{{ route('admin.avatar.approve', $request->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Подтвердить смену аватарки для пользователя {{ $request->user->name }}?')"
                            style="padding: 10px 25px; border-radius: 8px; background: rgba(0,255,136,0.2); color: #00ff88; border: 2px solid rgba(0,255,136,0.3); cursor: pointer; font-weight: bold; transition: 0.3s; font-size: 0.95em;"
                            onmouseover="this.style.background='rgba(0,255,136,0.3)'; this.style.transform='scale(1.02)'"
                            onmouseout="this.style.background='rgba(0,255,136,0.2)'; this.style.transform='scale(1)'">
                            ✅ Одобрить
                        </button>
                    </form>

                    <!-- Кнопка для показа формы отклонения -->
                    <button onclick="showRejectForm({{ $request->id }})"
                        style="padding: 10px 25px; border-radius: 8px; background: rgba(255,68,68,0.2); color: #ff4444; border: 2px solid rgba(255,68,68,0.3); cursor: pointer; font-weight: bold; transition: 0.3s; font-size: 0.95em;"
                        onmouseover="this.style.background='rgba(255,68,68,0.3)'; this.style.transform='scale(1.02)'"
                        onmouseout="this.style.background='rgba(255,68,68,0.2)'; this.style.transform='scale(1)'">
                        ❌ Отклонить
                    </button>

                </div>
            </div>

            <!-- Форма отклонения (скрыта) -->
            <div id="reject-form-{{ $request->id }}" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                <form action="{{ route('admin.avatar.reject', $request->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 10px;">
                        <label style="color: #aaa; font-size: 0.9em; display: block; margin-bottom: 5px;">Причина отклонения:</label>
                        <textarea name="rejection_reason" rows="3" required placeholder="Укажите причину отклонения запроса..."
                            style="width: 100%; padding: 10px; border-radius: 8px; background: #2a2a2a; color: white; border: 1px solid #444; box-sizing: border-box; resize: vertical;">{{ old('rejection_reason') }}</textarea>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit"
                            style="padding: 8px 20px; border-radius: 8px; background: #ff4444; color: white; border: none; cursor: pointer; font-weight: bold;">
                            Отправить
                        </button>
                        <button type="button" onclick="hideRejectForm({{ $request->id }})"
                            style="padding: 8px 20px; border-radius: 8px; background: #444; color: white; border: none; cursor: pointer;">
                            Отмена
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <script>
        function showRejectForm(id) {
            document.getElementById('reject-form-' + id).style.display = 'block';
        }

        function hideRejectForm(id) {
            document.getElementById('reject-form-' + id).style.display = 'none';
        }

        function previewAvatars(oldAvatar, newAvatar, userName) {
            document.getElementById('previewUser').textContent = '👤 ' + userName;

            // Старый аватар
            if (oldAvatar && oldAvatar !== 'avatars/default.png') {
                document.getElementById('previewOld').src = '/storage/' + oldAvatar;
                document.getElementById('previewOld').style.display = 'block';
            } else {
                document.getElementById('previewOld').style.display = 'none';
                document.querySelector('#previewOld').parentElement.innerHTML =
                    '<div style="font-size: 0.9em; color: #ff4444; margin-bottom: 10px;">Старый аватар</div>' +
                    '<div style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #ff4444; background: linear-gradient(135deg, #ff4444, #cc0000); display: flex; align-items: center; justify-content: center; color: white; font-size: 4em; font-weight: bold;">' +
                    userName.charAt(0).toUpperCase() +
                    '</div>';
                document.querySelector('#previewOld').style.display = 'none';
            }

            // Новый аватар
            if (newAvatar) {
                document.getElementById('previewNew').src = '/storage/' + newAvatar;
                document.getElementById('previewNew').style.display = 'block';
            }

            document.getElementById('previewModal').style.display = 'flex';
        }

        function closePreview() {
            document.getElementById('previewModal').style.display = 'none';
        }

        // Закрытие по клику вне модального окна
        document.getElementById('previewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePreview();
            }
        });

        // Закрытие по ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePreview();
            }
        });

        // Увеличение изображения при клике
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'IMG' && e.target.closest('#previewModal')) {
                const img = e.target;
                const isFullscreen = img.style.transform === 'scale(1.5)';
                img.style.transform = isFullscreen ? 'scale(1)' : 'scale(1.5)';
                img.style.transition = 'transform 0.3s';
                img.style.cursor = 'zoom-out';
            }
        });
    </script>

    <style>
        /* Стили для скролла */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #4facfe;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #00f2fe;
        }

        /* Анимация для карточек */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>

</html>