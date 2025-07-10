@extends('layouts.app')

@section('title', 'Beranda - Jasa Cuci Sepatu Sevatoo')

@section('content')
<!--========== HOME ==========-->
<section class="home" id="home">
    <div class="home__container bd-container bd-grid">
        <div class="home__data">
            <h1 class="home__title">SEVATOO</h1>
            <h2 class="home__subtitle">
                Jasa pembersih sepatu, <br />
                terjangkau, terbersih <br />
                dan tercepat.
            </h2>
            <div class="home__buttons">
                <a href="#menu" class="button">Lihat Menu</a>
                @auth
                    <a href="{{ route('booking.create') }}" class="button button-secondary">Booking Sekarang</a>
                @else
                    <a href="{{ route('login') }}" class="button button-secondary">Login untuk Booking</a>
                @endauth
            </div>
        </div>

        <img src="{{ asset('assets/img/LOGO BISNIS SEVATOO trans.png') }}" alt="Sevatoo Logo" class="home__img" />
    </div>
</section>

<!--========== ABOUT ==========-->
<section class="about section bd-container" id="about">
    <div class="about__container bd-grid">
        <div class="about__data">
            <span class="section-subtitle about__initial">Tentang kami</span>
            <h2 class="section-title about__initial">
                Menyediakan jasa <br />
                cuci sepatu terbaik.
            </h2>
            <p class="about__description">Kami siap menerima dan membersihkan sepatu anda, dengan layanan yang sangat baik, harga terbaik dan pastinya dengan hasil yang terbaik, kunjungi kami.</p>
            <a href="{{ route('about') }}" class="button">Tentang kami</a>
        </div>

        <img src="{{ asset('assets/img/aboutmee.png') }}" alt="About Us" class="about__img" />
    </div>
</section>

<!--========== SERVICES ==========-->
<section class="services section bd-container" id="services">
    <span class="section-subtitle">Menawarkan</span>
    <h2 class="section-title">Layanan terbaik kami</h2>

    <div class="services__container bd-grid">
        <div class="services__content">
            <svg class="services__img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M12.71,16.29l-.15-.12a.76.76,0,0,0-.18-.09L12.2,16a1,1,0,0,0-.91.27,1.15,1.15,0,0,0-.21.33,1,1,0,0,0,1.3,1.31,1.46,1.46,0,0,0,.33-.22,1,1,0,0,0,.21-1.09A1,1,0,0,0,12.71,16.29ZM16,2H8A3,3,0,0,0,5,5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V5A3,3,0,0,0,16,2Zm1,17a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z"
                />
            </svg>
            <h3 class="services__title">Reserve your spot</h3>
            <p class="services__description">Kami menyediakan fitur yang sangat memudahkan anda untuk memesan layanan kami ditempat anda sendiri.</p>
        </div>

        <div class="services__content">
            <svg class="services__img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M11,9h4a1,1,0,0,0,0-2H13V6a1,1,0,0,0-2,0V7a3,3,0,0,0,0,6h2a1,1,0,0,1,0,2H9a1,1,0,0,0,0,2h2v1a1,1,0,0,0,2,0V17a3,3,0,0,0,0-6H11a1,1,0,0,1,0-2Zm1-8A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,20a9,9,0,1,1,9-9A9,9,0,0,1,12,21Z"
                />
            </svg>
            <h3 class="services__title">Pricing</h3>
            <p class="services__description">Kami menawarkan harga yang terbaik sesuai jenis pelayanan apa yang anda pesan.</p>
        </div>

        <div class="services__content">
            <svg class="services__img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M1,12.5v5a1,1,0,0,0,1,1H3a3,3,0,0,0,6,0h6a3,3,0,0,0,6,0h1a1,1,0,0,0,1-1V5.5a3,3,0,0,0-3-3H11a3,3,0,0,0-3,3v2H6A3,3,0,0,0,3.6,8.7L1.2,11.9a.61.61,0,0,0-.07.14l-.06.11A1,1,0,0,0,1,12.5Zm16,6a1,1,0,1,1,1,1A1,1,0,0,1,17,18.5Zm-7-13a1,1,0,0,1,1-1h9a1,1,0,0,1,1,1v11h-.78a3,3,0,0,0-4.44,0H10Zm-2,6H4L5.2,9.9A1,1,0,0,1,6,9.5H8Zm-3,7a1,1,0,1,1,1,1A1,1,0,0,1,5,18.5Zm-2-5H8v2.78a3,3,0,0,0-4.22.22H3Z"
                />
            </svg>
            <h3 class="services__title">Delivery</h3>
            <p class="services__description">Kami juga menyediakan fitur pesan antar, pada saat anda memesan layanan kami, pihak kami akan mengambil barang tersebut dan mengantarkan ke lokasi anda jika proses sudah selesai.</p>
        </div>
    </div>
</section>

<!--========== MENU ==========-->
<section class="menu section bd-container" id="menu">
    <span class="section-subtitle">Spesial</span>
    <h2 class="section-title">Jenis layanan</h2>

    <div class="menu__container bd-grid">
        @foreach($services as $service)
        <div class="menu__content">
            <img src="{{ asset('assets/img/' . $service['image']) }}" alt="{{ $service['name'] }}" class="menu__img" />
            <h3 class="menu__name">{{ $service['name'] }}</h3>
            <span class="menu__detail">{{ $service['detail'] }}</span>
            <span class="menu__preci">{{ $service['price'] }}</span>
            @auth
                <a href="{{ route('booking.create', ['service' => $service['id'] ?? $loop->index + 1]) }}" class="button menu__button">
                    <i class="bx bx-cart-alt"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="button menu__button" title="Login untuk booking">
                    <i class="bx bx-cart-alt"></i>
                </a>
            @endauth
        </div>
        @endforeach
    </div>
</section>

<!--========== CONTACT US ==========-->
<section class="contact section bd-container" id="contact">
    <div class="contact__container bd-grid">
        <div class="contact__data">
            <span class="section-subtitle contact__initial">Let's talk</span>
            <h2 class="section-title contact__initial">Hubungi kami</h2>
            <p class="contact__description">Jika anda ingin memesan jasa kami, hubungi kami dan kami akan segera melayani anda.</p>
        </div>

        <div class="contact__button">
            @auth
                <a href="{{ route('booking.create') }}" class="button">Booking Sekarang</a>
            @else
                <a href="{{ route('login') }}" class="button">Login untuk Booking</a>
            @endauth
            <a href="{{ route('booking.track') }}" class="button button-outline">Lacak Booking</a>
        </div>
    </div>
</section>
@endsection