<x-head />
<x-header />

<body>
    <div class="admin-container">
        <div class="admin-box">
            <h2 class="admin-title">Управление пользователями</h2>

            @if(session('success'))
                <div class="profile-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="auth-error">{{ session('error') }}</div>
            @endif

            <!-- Ожидают модерации -->
            <div class="admin-section">
                <h3 class="admin-section-title">Ожидают модерации ({{ $pendingUsers->count() }})</h3>
                
                @if($pendingUsers->isEmpty())
                    <p class="admin-empty">Нет пользователей на модерации</p>
                @else
                    @foreach($pendingUsers as $user)
                        <div class="user-card pending">
                            <div class="user-avatar">
                                <img src="{{ $user->avatar }}" alt="Avatar">
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">{{ $user->email }}</div>
                                <div class="user-date">Зарегистрирован: {{ $user->created_at }}</div>
                            </div>
                            <div class="user-actions">
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-approve">✅ Одобрить</button>
                                </form>
                                
                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-reject">❌ Отклонить</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Активные пользователи -->
            <div class="admin-section">
                <h3 class="admin-section-title">Все принятые пользователи ({{ $activeUsers->count() }})</h3>
                
                @if($activeUsers->isEmpty())
                    <p class="admin-empty">Нет активных пользователей</p>
                @else
                    @foreach($activeUsers as $user)
                        <div class="user-card approved">
                            <div class="user-avatar">
                                <img src="{{ $user->avatar }}" alt="Avatar">
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">{{ $user->email }}</div>
                                <div class="user-date">Активирован: {{ $user->approved_at }}</div>
                                @if($user->role === 'admin')
                                    <span class="user-badge admin">Админ</span>
                                @endif
                            </div>
                            <div class="user-actions">
                                @if($user->role !== 'admin')
                                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите заблокировать этого пользователя?')">
                                        @csrf
                                        <button type="submit" class="btn-block">🔒 Заблокировать</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .admin-box {
            background: #141414;
            padding: 30px;
            border-radius: 16px;
            border: 1px solid #333;
        }

        .admin-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: #fff;
        }

        .admin-title span {
            color: #ff6b6b;
        }

        .admin-section {
            margin-bottom: 40px;
        }

        .admin-section-title {
            color: #fff;
            font-size: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(255, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .admin-empty {
            color: #666;
            text-align: center;
            padding: 20px;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 16px;
            background: #1a1a1a;
            border-radius: 10px;
            margin-bottom: 12px;
            border-left: 4px solid #444;
            flex-wrap: wrap;
        }

        .user-card.pending {
            border-left-color: #f39c12;
        }

        .user-card.approved {
            border-left-color: #2ecc71;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 10%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
            min-width: 150px;
        }

        .user-name {
            color: #fff;
            font-weight: 600;
            font-size: 16px;
        }

        .user-email {
            color: #aaa;
            font-size: 14px;
        }

        .user-date {
            color: #666;
            font-size: 12px;
            margin-top: 4px;
        }

        .user-badge {
            display: inline-block;
            padding: 2px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 4px;
        }

        .user-badge.admin {
            background: rgba(255, 59, 59, 0.2);
            color: #ff6b6b;
        }

        .user-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-approve {
            padding: 8px 16px;
            background: #2ecc71;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-approve:hover {
            background: #27ae60;
            transform: translateY(-2px);
        }

        .btn-reject {
            padding: 8px 16px;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-reject:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .btn-block {
            padding: 8px 16px;
            background: #f39c12;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-block:hover {
            background: #e67e22;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .user-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-actions {
                width: 100%;
            }

            .user-actions form {
                flex: 1;
            }

            .user-actions button {
                width: 100%;
            }
        }
    </style>
</body>
</html>