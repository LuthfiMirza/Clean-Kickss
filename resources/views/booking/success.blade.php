@extends('layouts.app')

@section('title', 'Booking Berhasil')

@push('styles')
<style>
    .success-hero {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 4rem 0;
        margin-top: 4rem;
        text-align: center;
    }
    
    .success-icon {
        width: 5rem;
        height: 5rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
    }
    
    .booking-details-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin: 2rem 0;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        color: var(--text-color);
        font-weight: 500;
    }
    
    .detail-value {
        font-weight: 600;
        color: var(--title-color);
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        background: #fef3c7;
        color: #92400e;
    }
    
    .price-value {
        color: var(--first-color);
        font-size: 1.2rem;
    }
    
    .steps-card {
        background: rgba(59, 130, 246, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 1rem;
        padding: 2rem;
        margin: 2rem 0;
    }
    
    .step-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .step-item:last-child {
        margin-bottom: 0;
    }
    
    .step-number {
        background: var(--first-color);
        color: white;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .btn-primary {
        background: var(--first-color);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        text-align: center;
        font-weight: 600;
        margin: 0.25rem;
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
        text-align: center;
        font-weight: 600;
        margin: 0.25rem;
    }
    
    .btn-secondary:hover {
        background: #059669;
        transform: translateY(-2px);
    }
    
    .btn-outline {
        background: transparent;
        color: var(--text-color);
        border: 2px solid #e5e7eb;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        text-align: center;
        font-weight: 600;
        margin: 0.25rem;
    }
    
    .btn-outline:hover {
        border-color: var(--first-color);
        color: var(--first-color);
        transform: translateY(-2px);
    }
    
    .contact-info {
        text-align: center;
        color: var(--text-color);
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--container-color);
        border-radius: 0.5rem;
    }
    
    .button-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 2rem 0;
    }
    
    @media (max-width: 768px) {
        .success-hero {
            padding: 2rem 0;
        }
        
        .booking-details-card {
            margin: 1rem;
            padding: 1.5rem;
        }
        
        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .button-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<!-- Success Hero -->
<section class="success-hero">
    <div class="bd-container">
        <div class="success-icon">
            <i class="bx bx-check"></i>
        </div>
        <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem;">Booking Berhasil!</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Terima kasih telah mempercayakan sepatu Anda kepada kami</p>
    </div>
</section>

<!-- Booking Details -->
<section class="section bd-container">
    <div class="booking-details-card">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: var(--title-color); margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--first-color); display: inline-block;">Detail Booking</h2>
            
            <div class="detail-row">
            <span class="detail-label">ID Booking:</span>
            <span class="detail-value" style="color: var(--first-color);">#{{ $booking->id }}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Nama Pelanggan:</span>
            <span class="detail-value">{{ $booking->customer->name }}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Nomor Telepon:</span>
            <span class="detail-value">{{ $booking->customer->phone }}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Layanan:</span>
            <span class="detail-value">{{ $booking->service->name }}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Total Harga:</span>
            <span class="detail-value price-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Tanggal Booking:</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Waktu Pickup:</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->pickup_time)->format('H:i') }}</span>
        </div>
        
        @if($booking->delivery_time)
        <div class="detail-row">
            <span class="detail-label">Waktu Delivery:</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->delivery_time)->format('H:i') }}</span>
        </div>
        @endif
        
        <div class="detail-row">
            <span class="detail-label">Metode Pembayaran:</span>
            <span class="detail-value">{{ $booking->payment_method_label }}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Status:</span>
            <span class="status-badge">{{ $booking->status_label }}</span>
        </div>
        
        @if($booking->notes)
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f3f4f6;">
            <span class="detail-label" style="display: block; margin-bottom: 0.5rem;">Catatan:</span>
            <p style="color: var(--title-color);">{{ $booking->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Next Steps -->
    <div class="steps-card">
        <h3 style="font-size: 1.2rem; font-weight: 600; color: var(--first-color); margin-bottom: 1rem;">Langkah Selanjutnya:</h3>
        <div class="step-item">
            <span class="step-number">1</span>
            <span style="color: var(--text-color);">Kami akan menghubungi Anda dalam 1-2 jam untuk konfirmasi booking</span>
        </div>
        <div class="step-item">
            <span class="step-number">2</span>
            <span style="color: var(--text-color);">Tim kami akan datang sesuai jadwal yang telah disepakati</span>
        </div>
        <div class="step-item">
            <span class="step-number">3</span>
            <span style="color: var(--text-color);">Sepatu akan dikerjakan dengan standar kualitas terbaik</span>
        </div>
        <div class="step-item">
            <span class="step-number">4</span>
            <span style="color: var(--text-color);">Sepatu siap diantar atau diambil sesuai kesepakatan</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="button-grid">
        <a href="{{ route('booking.show', $booking->id) }}" class="btn-primary">
            Lihat Detail Booking
        </a>
        <a href="{{ route('booking.track') }}" class="btn-secondary">
            Lacak Status Booking
        </a>
        <a href="{{ route('booking.create') }}" class="btn-outline">
            Booking Lagi
        </a>
    </div>

    <!-- Contact Info -->
    <div class="contact-info">
        <p style="margin-bottom: 0.5rem;">Butuh bantuan? Hubungi kami:</p>
        <p style="font-weight: 600; color: var(--title-color);">WhatsApp: +62 812-3456-7890</p>
        <p style="font-weight: 600; color: var(--title-color);">Email: info@cucisepatu.com</p>
    </div>
</section>
@endsection