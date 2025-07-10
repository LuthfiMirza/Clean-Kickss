<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--========== BOX ICONS ==========-->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />

    <!--========== CSS ==========-->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

    <title>@yield('title', 'Jasa Cuci Sepatu - Sevatoo')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/LOGO BISNIS SEVATOO trans.png') }}" />

    <!-- Profile Popup Styles -->
    <style>
        .profile-dropdown {
            position: relative;
        }

        .profile-trigger {
            display: flex !important;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-trigger:hover {
            color: var(--first-color) !important;
        }

        .profile-popup {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            min-width: 280px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .profile-popup.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-popup-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .profile-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--first-color), var(--first-color-alt));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .profile-info h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--title-color);
        }

        .profile-info p {
            margin: 0.25rem 0 0 0;
            font-size: 0.875rem;
            color: var(--text-color-light);
        }

        .profile-popup-body {
            padding: 0.5rem 0;
        }

        .profile-menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .profile-menu-item:hover {
            background: #f8fafc;
            color: var(--first-color);
        }

        .profile-menu-item i {
            font-size: 1.1rem;
            width: 20px;
        }

        .profile-popup-footer {
            padding: 0.5rem 0;
            border-top: 1px solid #f3f4f6;
        }

        .profile-logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            width: 100%;
            background: none;
            border: none;
            color: #dc2626;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            cursor: pointer;
            font-family: inherit;
        }

        .profile-logout-btn:hover {
            background: #fef2f2;
            color: #b91c1c;
        }

        .profile-logout-btn i {
            font-size: 1.1rem;
            width: 20px;
        }

        /* Dark theme support */
        body.dark-theme .profile-popup {
            background: var(--container-color);
            border-color: var(--first-color-lighten);
        }

        body.dark-theme .profile-popup-header {
            border-color: var(--first-color-lighten);
        }

        body.dark-theme .profile-popup-footer {
            border-color: var(--first-color-lighten);
        }

        body.dark-theme .profile-menu-item:hover {
            background: var(--first-color-lighten);
        }

        body.dark-theme .profile-logout-btn:hover {
            background: rgba(220, 38, 38, 0.1);
        }

        /* Mobile responsive */
        @media screen and (max-width: 768px) {
            .profile-popup {
                right: -1rem;
                min-width: 260px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!--========== SCROLL TOP ==========-->
    <a href="#" class="scrolltop" id="scroll-top">
        <i class="bx bx-chevron-up scrolltop__icon"></i>
    </a>

    <!--========== HEADER ==========-->
    <header class="l-header" id="header">
        <nav class="nav bd-container">
            <a href="{{ route('home') }}" class="nav__logo">Sevatoo</a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item"><a href="{{ route('home') }}" class="nav__link {{ request()->routeIs('home') ? 'active-link' : '' }}">Beranda</a></li>
                    <li class="nav__item"><a href="{{ route('about') }}" class="nav__link {{ request()->routeIs('about') ? 'active-link' : '' }}">Tentang</a></li>
                    <li class="nav__item"><a href="{{ route('booking.index') }}" class="nav__link {{ request()->routeIs('booking.*') && !request()->routeIs('booking.track*') ? 'active-link' : '' }}">Booking</a></li>
                    <li class="nav__item"><a href="{{ route('booking.track') }}" class="nav__link {{ request()->routeIs('booking.track*') ? 'active-link' : '' }}">Lacak</a></li>
                    
                    @auth
                        <li class="nav__item profile-dropdown">
                            <a href="#" class="nav__link profile-trigger" id="profile-trigger">
                                <i class="bx bx-user"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="bx bx-chevron-down"></i>
                            </a>
                            <div class="profile-popup" id="profile-popup">
                                <div class="profile-popup-header">
                                    <div class="profile-avatar">
                                        <i class="bx bx-user-circle"></i>
                                    </div>
                                    <div class="profile-info">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p>{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <div class="profile-popup-body">
                                    <a href="{{ route('dashboard') }}" class="profile-menu-item">
                                        <i class="bx bx-tachometer"></i>
                                        <span>Dashboard</span>
                                    </a>
                                    <a href="{{ route('dashboard.profile') }}" class="profile-menu-item">
                                        <i class="bx bx-user"></i>
                                        <span>Profil Saya</span>
                                    </a>
                                    <a href="{{ route('dashboard.bookings') }}" class="profile-menu-item">
                                        <i class="bx bx-calendar"></i>
                                        <span>Booking Saya</span>
                                    </a>
                                    <a href="{{ route('booking.create') }}" class="profile-menu-item">
                                        <i class="bx bx-plus"></i>
                                        <span>Booking Baru</span>
                                    </a>
                                </div>
                                <div class="profile-popup-footer">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="profile-logout-btn">
                                            <i class="bx bx-log-out"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @else
                        <li class="nav__item"><a href="{{ route('login') }}" class="nav__link {{ request()->routeIs('login') ? 'active-link' : '' }}">Login</a></li>
                        <li class="nav__item"><a href="{{ route('register') }}" class="nav__link {{ request()->routeIs('register') ? 'active-link' : '' }}">Daftar</a></li>
                    @endauth

                    <li><i class="bx bx-moon change-theme" id="theme-button"></i></li>
                </ul>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class="bx bx-menu"></i>
            </div>
        </nav>
    </header>

    <main class="l-main">
        @yield('content')
    </main>

    <!--========== FOOTER ==========-->
    <footer class="footer section bd-container">
        <div class="footer__container bd-grid">
            <div class="footer__content">
                <a href="{{ route('home') }}" class="footer__logo">Sevatoo</a>
                <span class="footer__description">Cleanning shoes & sneakers</span>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Layanan/jasa</h3>
                <ul>
                    <li><a href="{{ route('booking.create') }}" class="footer__link">Booking Baru</a></li>
                    <li><a href="{{ route('booking.track') }}" class="footer__link">Lacak Booking</a></li>
                    <li><a href="{{ route('booking.index') }}" class="footer__link">Lihat Layanan</a></li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Informasi</h3>
                <ul>
                    <li><a href="#" class="footer__link">Event</a></li>
                    <li><a href="#" class="footer__link">Contact us</a></li>
                    <li><a href="#" class="footer__link">Privacy policy</a></li>
                    <li><a href="#" class="footer__link">Terms of services</a></li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Alamat</h3>
                <ul>
                    <li>Sunter Agung</li>
                    <li>Jl. Sunter Karya Selatan V. DKI no. 16</li>
                    <li>081543425338</li>
                    <li>sevatoo@gmail.com</li>
                </ul>
            </div>
        </div>

        <p class="footer__copy">&#169; {{ date('Y') }} Sevatoo. All right reserved</p>
    </footer>

    <!--========== SCROLL REVEAL ==========-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!--========== MAIN JS ==========-->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <!--========== CART JS ==========-->
    <script src="{{ asset('assets/js/cart.js') }}"></script>

    <!-- Profile Popup JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileTrigger = document.getElementById('profile-trigger');
            const profilePopup = document.getElementById('profile-popup');

            if (profileTrigger && profilePopup) {
                // Toggle popup on click
                profileTrigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    profilePopup.classList.toggle('show');
                });

                // Close popup when clicking outside
                document.addEventListener('click', function(e) {
                    if (!profileTrigger.contains(e.target) && !profilePopup.contains(e.target)) {
                        profilePopup.classList.remove('show');
                    }
                });

                // Close popup when pressing Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        profilePopup.classList.remove('show');
                    }
                });

                // Prevent popup from closing when clicking inside it
                profilePopup.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>