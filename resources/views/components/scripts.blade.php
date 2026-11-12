<script 
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" 
crossorigin="anonymous">
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const closeMenu = document.getElementById('closeMenu');
    const mobileMenu = document.getElementById('mobileMenu');
    const body = document.body;

    // Открыть меню
    function openMenu() {
        mobileMenu.classList.add('active');
        body.style.overflow = 'hidden';
    }

    // Закрыть меню
    function closeMenuFunc() {
        mobileMenu.classList.remove('active');
        body.style.overflow = '';
    }

    // Обработчики
    if (menuToggle) {
        menuToggle.addEventListener('click', openMenu);
    }

    if (closeMenu) {
        closeMenu.addEventListener('click', closeMenuFunc);
    }

    // Закрытие по клику на фон
    mobileMenu.addEventListener('click', function(e) {
        if (e.target === mobileMenu || e.target === mobileMenu.querySelector('.mobile-menu-overlay')) {
            closeMenuFunc();
        }
    });

    // Закрытие по Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            closeMenuFunc();
        }
    });

    // Закрытие при клике на любую кнопку в меню
    document.querySelectorAll('.mobile-nav-btn, .mobile-auth-btn, .mobile-search-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Проверяем, не является ли кнопка ссылкой на другую страницу
            if (!this.hasAttribute('onclick')) {
                closeMenuFunc();
            } else {
                // Даем время выполниться переходу
                setTimeout(closeMenuFunc, 100);
            }
        });
    });

    // Кнопка профиля
    const profileBtn = document.getElementById('profileBtn');
    if (profileBtn) {
        profileBtn.addEventListener('click', function() {
            @if(Auth::check() && Auth::user()->role == 'client')
                window.location.href = '{{ route('profile') }}';
            @else
                window.location.href = '{{ route('auth') }}';
            @endif
        });
    }
});
</script>