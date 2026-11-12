
    <!-- <div class="mobile-buttons"> -->
        <!-- <button class="mobile-btn profile-btn" id="profileBtn"> -->
            <!-- @if(Auth::check() && Auth::user()->role == 'client') -->
                <!-- <img class="mobile-avatar" src="{{ auth()->user()->avatar }}" alt="Avatar"> -->
            <!-- @else -->
                <!-- <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"> -->
                    <!-- <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/> -->
                    <!-- <circle cx="12" cy="7" r="4"/> -->
                <!-- </svg> -->
            <!-- @endif -->
        <!-- </button> -->
        
        <!-- <button class="mobile-btn menu-btn" id="menuToggle">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
    </div> -->

    
    <!-- <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-overlay">
            <div class="mobile-menu-content">
                
                <div class="mobile-menu-header">
                    <span class="mobile-menu-title">Меню</span>
                    <button class="mobile-close-btn" id="closeMenu">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                </div>

                <nav class="mobile-nav">
                    <button class="mobile-nav-btn">РЕЙТИНГ</button>
                    <button class="mobile-nav-btn">ПРЕМИЯ JMA</button>
                    <button class="mobile-nav-btn">ВЫБОР MELO</button>

                    <form action="{{ route('search') }}" method="GET" class="mobile-search-form">
                        <input type="text" name="q" placeholder="Поиск треков..." class="mobile-search-input">
                        <button type="submit" class="mobile-search-btn">Найти</button>
                    </form>

                    <div class="mobile-auth-buttons">
                        @if(Auth::check() && Auth::user()->role == 'client')
                            <button class="mobile-auth-btn mobile-profile-btn" onclick="window.location='{{ route('profile') }}'">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                Профиль
                            </button>
                        @else
                            <button class="mobile-auth-btn" onclick="window.location='{{ route('auth') }}'">АВТОРИЗАЦИЯ</button>
                            <button class="mobile-auth-btn mobile-register-btn" onclick="window.location='{{ route('register') }}'">РЕГИСТРАЦИЯ</button>
                        @endif
                    </div>
                </nav>
            </div>
        </div>
    </div> -->