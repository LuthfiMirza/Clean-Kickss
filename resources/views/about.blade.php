@extends('layouts.app')

@section('title', 'Tentang Kami - Sevatoo')

@section('content')
<!--========== ABOUT PAGE ==========-->
<section class="about section bd-container" style="padding-top: 8rem;">
    <div class="about__container bd-grid">
        <div class="about__data">
            <span class="section-subtitle about__initial">Tentang kami</span>
            <h2 class="section-title about__initial">
                Sevatoo - Jasa Cuci Sepatu <br />
                Terpercaya di Jakarta Utara
            </h2>
            <p class="about__description">
                Sevatoo adalah layanan jasa cuci sepatu profesional yang berlokasi di Sunter Agung, Jakarta Utara. 
                Kami berkomitmen untuk memberikan layanan terbaik dalam membersihkan berbagai jenis sepatu dengan 
                teknologi dan produk pembersih berkualitas tinggi.
            </p>
            <p class="about__description">
                Dengan pengalaman bertahun-tahun, kami telah melayani ribuan pelanggan dengan hasil yang memuaskan. 
                Tim profesional kami memahami karakteristik berbagai material sepatu dan menggunakan teknik pembersihan 
                yang tepat untuk setiap jenis sepatu.
            </p>
        </div>

        <img src="{{ asset('assets/img/aboutmee.png') }}" alt="About Sevatoo" class="about__img" />
    </div>
</section>

<!--========== OUR SERVICES DETAIL ==========-->
<section class="services section bd-container">
    <span class="section-subtitle">Keunggulan</span>
    <h2 class="section-title">Mengapa Memilih Sevatoo?</h2>

    <div class="services__container bd-grid">
        <div class="services__content">
            <svg class="services__img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"/>
                <path d="m9,12,2,2,4-4"/>
            </svg>
            <h3 class="services__title">Kualitas Terjamin</h3>
            <p class="services__description">Menggunakan produk pembersih berkualitas tinggi dan teknik pembersihan profesional untuk hasil yang maksimal.</p>
        </div>

        <div class="services__content">
            <svg class="services__img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm1,17.93V17a1,1,0,0,0-2,0v2.93A8,8,0,0,1,4.07,13H7a1,1,0,0,0,0-2H4.07A8,8,0,0,1,11,4.07V7a1,1,0,0,0,2,0V4.07A8,8,0,0,1,19.93,11H17a1,1,0,0,0,0,2h2.93A8,8,0,0,1,13,19.93Z"/>
            </svg>
            <h3 class="services__title">Proses Cepat</h3>
            <p class="services__description">Layanan express dengan waktu pengerjaan yang cepat tanpa mengurangi kualitas hasil pembersihan.</p>
        </div>

        <div class="services__content">
            <svg class="services__img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"/>
                <path d="M12,6a1,1,0,0,0-1,1v5a1,1,0,0,0,.29.71l3,3a1,1,0,0,0,1.42-1.42L13,11.59V7A1,1,0,0,0,12,6Z"/>
            </svg>
            <h3 class="services__title">Harga Terjangkau</h3>
            <p class="services__description">Menawarkan harga yang kompetitif dan terjangkau untuk semua kalangan dengan kualitas premium.</p>
        </div>

        <div class="services__content">
            <svg class="services__img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M19,2H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V5A3,3,0,0,0,19,2Zm1,17a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4H19a1,1,0,0,1,1,1Z"/>
                <path d="m9,12,2,2,4-4"/>
            </svg>
            <h3 class="services__title">Layanan Antar Jemput</h3>
            <p class="services__description">Kemudahan layanan antar jemput untuk area Jakarta Utara dan sekitarnya dengan biaya yang terjangkau.</p>
        </div>
    </div>
</section>

<!--========== CONTACT INFO ==========-->
<section class="contact section bd-container">
    <div class="contact__container bd-grid">
        <div class="contact__data">
            <span class="section-subtitle contact__initial">Lokasi & Kontak</span>
            <h2 class="section-title contact__initial">Kunjungi Kami</h2>
            <p class="contact__description">
                <strong>Alamat:</strong><br>
                Jl. Sunter Karya Selatan V. DKI no. 16<br>
                Sunter Agung<br><br>
                <strong>Telepon:</strong> +62 815-4342-5338<br>
                <strong>Email:</strong> sevatoo@gmail.com
            </p>
        </div>

        <div class="contact__button">
            <a href="https://wa.me/6281543425338" class="button" target="_blank">
                <i class="bx bxl-whatsapp"></i> WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection