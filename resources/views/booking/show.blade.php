@extends('layouts.app')

@section('title', 'Detail Booking #' . $booking->id)

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endpush

@section('content')
<section class="booking-detail section bd-container">
    <div class="booking-detail__container">
        <!-- Header -->
        <div class="booking-detail__header">
            <h1 class="section-title">Detail Booking #{{ $booking->id }}</h1>
            <p class="booking-detail__subtitle">Informasi lengkap booking cuci sepatu</p>
        </div>

        <div class="booking-detail__grid">
            <!-- Main Content -->
            <div class="booking-detail__main">
                <!-- Status Card -->
                <div class="booking-detail__card">
                    <h2 class="booking-detail__card-title">Status Booking</h2>
                    
                    @php
                        $statusClasses = [
                            'pending' => 'booking-detail__status--pending',
                            'confirmed' => 'booking-detail__status--confirmed',
                            'picked_up' => 'booking-detail__status--picked',
                            'in_progress' => 'booking-detail__status--processing',
                            'ready' => 'booking-detail__status--ready',
                            'delivered' => 'booking-detail__status--completed',
                            'cancelled' => 'booking-detail__status--cancelled'
                        ];
                        $statusClass = $statusClasses[$booking->status] ?? 'booking-detail__status--default';
                        
                        $statusProgress = [
                            'pending' => 10,
                            'confirmed' => 25,
                            'picked_up' => 40,
                            'in_progress' => 60,
                            'ready' => 80,
                            'delivered' => 100,
                            'cancelled' => 0
                        ];
                        $progress = $statusProgress[$booking->status] ?? 0;
                        
                        $statusLabels = [
                            'pending' => 'Menunggu Konfirmasi',
                            'confirmed' => 'Dikonfirmasi',
                            'picked_up' => 'Sudah Diambil',
                            'in_progress' => 'Sedang Dikerjakan',
                            'ready' => 'Siap Diantar',
                            'delivered' => 'Sudah Diantar',
                            'cancelled' => 'Dibatalkan'
                        ];
                    @endphp
                    
                    <div class="booking-detail__status-header">
                        <span class="booking-detail__status {{ $statusClass }}">
                            {{ $statusLabels[$booking->status] ?? ucwords(str_replace('_', ' ', $booking->status)) }}
                        </span>
                        <span class="booking-detail__progress-text">{{ $progress }}% Selesai</span>
                    </div>
                    
                    <div class="booking-detail__progress-bar">
                        <div class="booking-detail__progress-fill" style="width: {{ $progress }}%"></div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="booking-detail__timeline">
                        @php
                            $timelineStatuses = [
                                'pending' => 'Menunggu Konfirmasi',
                                'confirmed' => 'Dikonfirmasi',
                                'picked_up' => 'Sudah Diambil',
                                'in_progress' => 'Sedang Dikerjakan',
                                'ready' => 'Siap Diantar',
                                'delivered' => 'Sudah Diantar'
                            ];
                            $currentStatusIndex = array_search($booking->status, array_keys($timelineStatuses));
                            // If status is cancelled, don't show any as completed
                            if ($booking->status === 'cancelled') {
                                $currentStatusIndex = -1;
                            }
                        @endphp
                        
                        @foreach($timelineStatuses as $statusKey => $statusLabel)
                            @php
                                $statusIndex = array_search($statusKey, array_keys($timelineStatuses));
                                $isCompleted = $currentStatusIndex !== false && $statusIndex <= $currentStatusIndex;
                                $isCurrent = $statusKey === $booking->status;
                            @endphp
                            
                            <div class="booking-detail__timeline-item {{ $isCompleted ? 'booking-detail__timeline-item--completed' : '' }} {{ $isCurrent ? 'booking-detail__timeline-item--current' : '' }}">
                                <div class="booking-detail__timeline-dot"></div>
                                <span class="booking-detail__timeline-label">{{ $statusLabel }}</span>
                            </div>
                        @endforeach
                        
                        @if($booking->status === 'cancelled')
                        <div class="booking-detail__timeline-item booking-detail__timeline-item--current">
                            <div class="booking-detail__timeline-dot"></div>
                            <span class="booking-detail__timeline-label">Dibatalkan</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="booking-detail__card">
                    <h2 class="booking-detail__card-title">Detail Booking</h2>
                    
                    <div class="booking-detail__details-grid">
                        <div class="booking-detail__detail-item">
                            <p class="booking-detail__detail-label">Tanggal Booking</p>
                            <p class="booking-detail__detail-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</p>
                        </div>
                        <div class="booking-detail__detail-item">
                            <p class="booking-detail__detail-label">Waktu Pickup</p>
                            <p class="booking-detail__detail-value">{{ \Carbon\Carbon::parse($booking->pickup_time)->format('H:i') }}</p>
                        </div>
                        @if($booking->delivery_time)
                        <div class="booking-detail__detail-item">
                            <p class="booking-detail__detail-label">Waktu Delivery</p>
                            <p class="booking-detail__detail-value">{{ \Carbon\Carbon::parse($booking->delivery_time)->format('H:i') }}</p>
                        </div>
                        @endif
                        <div class="booking-detail__detail-item">
                            <p class="booking-detail__detail-label">Dibuat Pada</p>
                            <p class="booking-detail__detail-value">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($booking->notes)
                    <div class="booking-detail__notes">
                        <p class="booking-detail__detail-label">Catatan Khusus</p>
                        <p class="booking-detail__detail-value">{{ $booking->notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Service Details -->
                <div class="booking-detail__card">
                    <h2 class="booking-detail__card-title">Detail Layanan</h2>
                    
                    <div class="booking-detail__service">
                        <div class="booking-detail__service-info">
                            <h3 class="booking-detail__service-name">{{ $booking->service->name }}</h3>
                            <p class="booking-detail__service-description">{{ $booking->service->description }}</p>
                            <p class="booking-detail__service-duration">Durasi: {{ $booking->service->duration_minutes }} menit</p>
                        </div>
                        <div class="booking-detail__service-price">
                            <p class="booking-detail__price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="booking-detail__sidebar">
                <!-- Customer Info -->
                <div class="booking-detail__card">
                    <h2 class="booking-detail__card-title">Informasi Pelanggan</h2>
                    
                    <div class="booking-detail__info-list">
                        <div class="booking-detail__info-item">
                            <p class="booking-detail__detail-label">Nama</p>
                            <p class="booking-detail__detail-value">{{ $booking->customer->name }}</p>
                        </div>
                        <div class="booking-detail__info-item">
                            <p class="booking-detail__detail-label">Telepon</p>
                            <p class="booking-detail__detail-value">{{ $booking->customer->phone }}</p>
                        </div>
                        @if($booking->customer->email)
                        <div class="booking-detail__info-item">
                            <p class="booking-detail__detail-label">Email</p>
                            <p class="booking-detail__detail-value">{{ $booking->customer->email }}</p>
                        </div>
                        @endif
                        <div class="booking-detail__info-item">
                            <p class="booking-detail__detail-label">Alamat</p>
                            <p class="booking-detail__detail-value">{{ $booking->customer->address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="booking-detail__card">
                    <h2 class="booking-detail__card-title">Informasi Pembayaran</h2>
                    
                    <div class="booking-detail__info-list">
                        <div class="booking-detail__info-item">
                            <p class="booking-detail__detail-label">Total Harga</p>
                            <p class="booking-detail__detail-value booking-detail__price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="booking-detail__info-item">
                            <p class="booking-detail__detail-label">Metode Pembayaran</p>
                            <p class="booking-detail__detail-value">{{ ucwords(str_replace('_', ' ', $booking->payment_method)) }}</p>
                        </div>
                        <div class="booking-detail__info-item">
                            <p class="booking-detail__detail-label">Status Pembayaran</p>
                            @php
                                $paymentClasses = [
                                    'pending' => 'booking-detail__payment--unpaid',
                                    'paid' => 'booking-detail__payment--paid',
                                    'refunded' => 'booking-detail__payment--refunded'
                                ];
                                $paymentClass = $paymentClasses[$booking->payment_status] ?? 'booking-detail__payment--default';
                                
                                $paymentLabels = [
                                    'pending' => 'Belum Bayar',
                                    'paid' => 'Sudah Bayar',
                                    'refunded' => 'Dikembalikan'
                                ];
                            @endphp
                            <p class="booking-detail__detail-value {{ $paymentClass }}">{{ $paymentLabels[$booking->payment_status] ?? ucwords(str_replace('_', ' ', $booking->payment_status)) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="booking-detail__help">
                    <h3 class="booking-detail__help-title">Butuh Bantuan?</h3>
                    <div class="booking-detail__help-content">
                        <p class="booking-detail__help-item"><strong>WhatsApp: +62 815-4342-5338</strong></p>
                        <p class="booking-detail__help-item"><strong>Email: info@cucisepatu.com</strong></p>
                        <p class="booking-detail__help-text">Jam operasional: 08:00 - 20:00</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="booking-detail__actions">
            <a href="{{ route('booking.track') }}" class="button booking-detail__button--primary">
                Lacak Booking Lain
            </a>
            <a href="{{ route('booking.create') }}" class="button booking-detail__button--success">
                Booking Baru
            </a>
            <a href="{{ route('home') }}" class="button booking-detail__button--secondary">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection