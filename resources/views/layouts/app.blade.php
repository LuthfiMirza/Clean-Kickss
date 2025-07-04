<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    === BOX ICONS========== BOX ICONS ==========-->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />

    <!--========== CSS ==========-->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

    <title>@yield('title', 'Jasa Cuci Sepatu - Sevato')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/LOGO BISNIS SEVATOO trans.png') }}" />

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
            <a href="{{ route('home') }}" class="nav__logo">Sevato</a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item"><a href="{{ route('home') }}" class="nav__link {{ request()->routeIs('home') ? 'active-link' : '' }}">Beranda</a></li>
                    <li class="nav__item"><a href="{{ route('about') }}" class="nav__link {{ request()->routeIs('about') ? 'active-link' : '' }}">Tentang</a></li>
                    <li class="nav__item"><a href="{{ route('booking.index') }}" class="nav__link {{ request()->routeIs('booking.*') && !request()->routeIs('booking.track*') ? 'active-link' : '' }}">Booking</a></li>
                    <li class="nav__item"><a href="{{ route('booking.track') }}" class="nav__link {{ request()->routeIs('booking.track*') ? 'active-link' : '' }}">Lacak</a></li>
                    
                    @auth
                        <li class="nav__item"><a href="{{ route('dashboard') }}" class="nav__link {{ request()->routeIs('dashboard*') ? 'active-link' : '' }}">Dashboard</a></li>
                        <li class="nav__item">
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="nav__link" style="background: none; border: none; cursor: pointer; font-family: inherit; font-size: inherit; color: inherit;">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav__item"><a href="{{ route('login') }}" class="nav__link {{ request()->routeIs('login') ? 'active-link' : '' }}">Login</a></li>
                        <li class="nav__item"><a href="{{ route('register') }}" class="nav__link {{ request()->routeIs('register') ? 'active-link' : '' }}">Daftar</a></li>
                    @endauth
                    
                    <li class="nav__item"><a href="#contact" class="nav__link">Hubungi</a></li>

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
                <a href="{{ route('home') }}" class="footer__logo">Sevato</a>
                <span class="footer__description">Cleanning shoes & sneakers</span>
                <div>
                    <a href="#" class="footer__social"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="footer__social"><i class="bx bxl-instagram"></i></a>
                    <a href="#" class="footer__social"><i class="bx bxl-twitter"></i></a>
                </div>
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
                    <li>Purwokerto Utara - Banyumas</li>
                    <li>Jl. Letjen Pol. Soemarto No. 126</li>
                    <li>085267145967</li>
                    <li>sevato@gmail.com</li>
                </ul>
            </div>
        </div>

        <p class="footer__copy">&#169; {{ date('Y') }} Sevato. All right reserved</p>
    </footer>

    <!--========== SCROLL REVEAL ==========-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!--========== MAIN JS ==========-->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <!--========== CART JS ==========-->
    <script src="{{ asset('assets/js/cart.js') }}"></script>

    @stack('scripts')
</body>
</html>