@extends('layouts.app')

@section('title', 'Layanan Booking')

@push('styles')
<style>
    .booking-hero {
        background: linear-gradient(135deg, var(--first-color) 0%, var(--first-color-alt) 100%);
        color: white;
        padding: 4rem 0;
        margin-top: 4rem;
    }
    
    .service-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .btn-primary {
        background: var(--first-color);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary:hover {
        background: var(--first-color-alt);
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background: #10b981;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        margin: 0.5rem;
    }
    
    .btn-secondary:hover {
        background: #059669;
        transform: translateY(-2px);
    }
    
    .btn-outline {
        background: transparent;
        color: #f97316;
        border: 2px solid #f97316;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        margin: 0.5rem;
    }
    
    .btn-outline:hover {
        background: #f97316;
        color: white;
        transform: translateY(-2px);
    }
    
    .feature-icon {
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }
    
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin: 3rem 0;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin: 4rem 0;
    }
    
    @media (max-width: 768px) {
        .booking-hero {
            padding: 2rem 0;
        }
        
        .services-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="booking-hero">
    <div class="bd-container">
        <div style="text-align: center;">
            <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem;">Layanan Cuci Sepatu</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">Pilih layanan terbaik untuk sepatu kesayangan Anda</p>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section bd-container">
    <div class="services-grid">
        @foreach($services as $service)
        <div class="service-card">
            <div style="padding: 2rem;">
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: var(--title-color);">{{ $service->name }}</h3>
                <p style="color: var(--text-color); margin-bottom: 1.5rem; line-height: 1.6;">{{ $service->description }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <span style="font-size: 1.8rem; font-weight: bold; color: var(--first-color);">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                    <span style="font-size: 0.9rem; color: var(--text-color-light);">{{ $service->duration_minutes }} menit</span>
                </div>
                @auth
                    <a href="{{ route('booking.create', ['service' => $service->id]) }}" class="btn-primary" style="width: 100%; text-align: center;">
                        Pesan Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary" style="width: 100%; text-align: center;">
                        Login untuk Pesan
                    </a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>

    <!-- Action Buttons -->
    <div style="text-align: center; margin: 3rem 0;">
        @auth
            <a href="{{ route('booking.create') }}" class="btn-secondary">
                Buat Booking Baru
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-secondary">
                Login untuk Booking
            </a>
        @endauth
        <a href="{{ route('booking.track') }}" class="btn-outline">
            Lacak Booking
        </a>
    </div>
</section>

<!-- Features Section -->
<section class="section bd-container" style="background: var(--container-color); padding: 3rem 0; border-radius: 1rem;">
    <div class="features-grid">
        <div style="text-align: center;">
            <div class="feature-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                <i class="bx bx-time"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; color: var(--title-color);">Pickup & Delivery</h3>
            <p style="color: var(--text-color); line-height: 1.6;">Kami jemput dan antar sepatu Anda sesuai jadwal yang disepakati</p>
        </div>
        <div style="text-align: center;">
            <div class="feature-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="bx bx-check-shield"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; color: var(--title-color);">Kualitas Terjamin</h3>
            <p style="color: var(--text-color); line-height: 1.6;">Menggunakan produk berkualitas tinggi dan teknik pembersihan profesional</p>
        </div>
        <div style="text-align: center;">
            <div class="feature-icon" style="background: rgba(147, 51, 234, 0.1); color: #9333ea;">
                <i class="bx bx-rocket"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; color: var(--title-color);">Proses Cepat</h3>
            <p style="color: var(--text-color); line-height: 1.6;">Pengerjaan cepat dengan hasil maksimal, siap dalam waktu yang dijanjikan</p>
        </div>
    </div>
</section>
@endsection