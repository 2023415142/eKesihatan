<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>eKesihatan</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to content</a>
    <header>
        <div class="brand">
            <h1><a href="{{ route('landing') }}">eKesihatan</a></h1>
            <span class="brand-subtitle">Unit Kesihatan UiTM Perlis</span>
        </div>
        <div class="header-actions">
            <div class="language-controls">
                <label class="font-label" for="language-select">Language</label>
                <select id="language-select">
                    <option value="en">English</option>
                    <option value="ms">Bahasa Melayu</option>
                </select>
            </div>
            <div class="font-controls">
                <span class="font-label">Font size</span>
                <button type="button" data-font-size="14">A-</button>
                <button type="button" data-font-size="16" class="active">A</button>
                <button type="button" data-font-size="18">A+</button>
            </div>
            <nav class="top-nav">
                @guest
                    <a href="{{ route('landing') }}">Home</a>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endguest
            </nav>
        </div>
    </header>

    <div class="app-shell">
        @auth
            <aside class="sidebar">
                <div class="sidebar-title">Navigation</div>
                <nav class="sidebar-nav">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Admin Dashboard</a>
                        <a href="{{ route('admin.services.index') }}"><span class="icon">🩺</span> Health Services</a>
                        <a href="{{ route('admin.doctors.index') }}"><span class="icon">👩‍⚕️</span> Doctors</a>
                        <a href="{{ route('admin.slots.index') }}"><span class="icon">🗓️</span> Appointment Slots</a>
                        <a href="{{ route('admin.appointments.index') }}"><span class="icon">📋</span> Appointments</a>
                    @elseif (auth()->user()->isDoctor())
                        <a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Doctor Dashboard</a>
                        <a href="{{ route('doctor.appointments.index') }}"><span class="icon">📅</span> Daily Appointments</a>
                    @else
                        <a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Patient Dashboard</a>
                        <a href="{{ route('patient.services.index') }}"><span class="icon">🧾</span> Health Services</a>
                        <a href="{{ route('patient.appointments.create') }}"><span class="icon">➕</span> Book Appointment</a>
                        <a href="{{ route('patient.appointments.index') }}"><span class="icon">📋</span> My Appointments</a>
                    @endif

                    <a href="{{ route('profile.edit') }}"><span class="icon">👤</span> Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="sidebar-logout">
                        @csrf
                        <button type="submit"><span class="icon">🚪</span> Logout</button>
                    </form>
                </nav>
            </aside>
        @endauth

        <main id="main-content" class="main-content">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>

    <footer>
        <p>Unit Kesihatan UiTM Perlis · eKesihatan Appointment System</p>
    </footer>

    <script>
        (function () {
            const buttons = document.querySelectorAll('[data-font-size]');
            const root = document.documentElement;
            const storageKey = 'ekesihatan-font-size';
            const applySize = (size) => {
                root.style.setProperty('--base-font-size', size + 'px');
                buttons.forEach((button) => {
                    const isActive = button.dataset.fontSize === size;
                    button.classList.toggle('active', isActive);
                });
            };
            applySize(localStorage.getItem(storageKey) || '16');
            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    const size = button.dataset.fontSize;
                    localStorage.setItem(storageKey, size);
                    applySize(size);
                });
            });
        })();
    </script>

    <script>
        (function () {
            const translations = { ms: { 'Home':'Laman Utama','Login':'Log Masuk','Register':'Daftar' } };
            const languageSelect = document.getElementById('language-select');
            const applyLanguage = (lang) => {
                document.documentElement.lang = lang;
                document.querySelectorAll('[data-i18n]').forEach((el) => {
                    const key = el.getAttribute('data-i18n');
                    el.textContent = (translations[lang] && translations[lang][key]) || key;
                });
            };
            const storedLang = localStorage.getItem('ekesihatan-lang') || 'en';
            languageSelect.value = storedLang;
            applyLanguage(storedLang);
            languageSelect.addEventListener('change', () => {
                const lang = languageSelect.value;
                localStorage.setItem('ekesihatan-lang', lang);
                applyLanguage(lang);
            });
        })();
    </script>
</body>
</html>