@extends('layouts.app')

@section('title', 'Semua Booking')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endpush

@section('content')
<section class="dashboard-bookings section bd-container">
    <div class="dashboard-bookings__container">
        <!-- Header -->
        <div class="dashboard-bookings__header">
            <div class="dashboard-bookings__title-section">
                <h1 class="section-title">Semua Booking</h1>
                <p class="dashboard-bookings__subtitle">Riwayat lengkap booking cuci sepatu Anda</p>
            </div>
            <div class="dashboard-bookings__actions">
                <a href="{{ route('dashboard') }}" class="button dashboard-bookings__button--secondary">
                    Kembali ke Dashboard
                </a>
                <a href="{{ route('booking.create') }}" class="button dashboard-bookings__button--primary">
                    Booking Baru
                </a>
            </div>
        </div>

        @if($bookings->count() > 0)
            <div class="dashboard-bookings__list">
                @foreach($bookings as $booking)
                <div class="dashboard-bookings__card">
                    <div class="dashboard-bookings__card-header">
                        <div class="dashboard-bookings__booking-info">
                            <h3 class="dashboard-bookings__booking-title">Booking #{{ $booking->id }}</h3>
                            <p class="dashboard-bookings__service-name">{{ $booking->service->name }}</p>
                        </div>
                        <div class="dashboard-bookings__status-info">
                            @php
                                $statusClasses = [
                                    'pending' => 'dashboard-bookings__status--pending',
                                    'confirmed' => 'dashboard-bookings__status--confirmed',
                                    'picked_up' => 'dashboard-bookings__status--picked',
                                    'in_progress' => 'dashboard-bookings__status--processing',
                                    'ready' => 'dashboard-bookings__status--ready',
                                    'delivered' => 'dashboard-bookings__status--completed',
                                    'cancelled' => 'dashboard-bookings__status--cancelled'
                                ];
                                $statusClass = $statusClasses[$booking->status] ?? 'dashboard-bookings__status--default';
                                
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
                            <span class="dashboard-bookings__status {{ $statusClass }}">
                                {{ $statusLabels[$booking->status] ?? ucwords(str_replace('_', ' ', $booking->status)) }}
                            </span>
                            <p class="dashboard-bookings__date">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="dashboard-bookings__details">
                        <div class="dashboard-bookings__detail-item">
                            <p class="dashboard-bookings__detail-label">Tanggal Booking</p>
                            <p class="dashboard-bookings__detail-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</p>
                        </div>
                        <div class="dashboard-bookings__detail-item">
                            <p class="dashboard-bookings__detail-label">Waktu Pickup</p>
                            <p class="dashboard-bookings__detail-value">{{ \Carbon\Carbon::parse($booking->pickup_time)->format('H:i') }}</p>
                        </div>
                        <div class="dashboard-bookings__detail-item">
                            <p class="dashboard-bookings__detail-label">Total Harga</p>
                            <p class="dashboard-bookings__detail-value dashboard-bookings__price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="dashboard-bookings__detail-item">
                            <p class="dashboard-bookings__detail-label">Pembayaran</p>
                            @php
                                $paymentClasses = [
                                    'pending' => 'dashboard-bookings__payment--unpaid',
                                    'paid' => 'dashboard-bookings__payment--paid',
                                    'refunded' => 'dashboard-bookings__payment--refunded'
                                ];
                                $paymentClass = $paymentClasses[$booking->payment_status] ?? 'dashboard-bookings__payment--default';
                                
                                $paymentLabels = [
                                    'pending' => 'Belum Bayar',
                                    'paid' => 'Sudah Bayar',
                                    'refunded' => 'Dikembalikan'
                                ];
                            @endphp
                            <p class="dashboard-bookings__detail-value {{ $paymentClass }}">{{ $paymentLabels[$booking->payment_status] ?? ucwords(str_replace('_', ' ', $booking->payment_status)) }}</p>
                        </div>
                    </div>

                    @if($booking->notes)
                    <div class="dashboard-bookings__notes">
                        <p class="dashboard-bookings__detail-label">Catatan</p>
                        <p class="dashboard-bookings__detail-value">{{ $booking->notes }}</p>
                    </div>
                    @endif

                    <!-- Progress Bar -->
                    <div class="dashboard-bookings__progress">
                        <div class="dashboard-bookings__progress-header">
                            <span class="dashboard-bookings__progress-label">Progress</span>
                            @php
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
                            @endphp
                            <span class="dashboard-bookings__progress-percentage">{{ $progress }}%</span>
                        </div>
                        <div class="dashboard-bookings__progress-bar">
                            <div class="dashboard-bookings__progress-fill" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <div class="dashboard-bookings__actions">
                        <a href="{{ route('booking.show', $booking->id) }}" class="button dashboard-bookings__button--primary">
                            Lihat Detail
                        </a>
                        @if($booking->status === 'pending')
                        <span class="dashboard-bookings__status-badge dashboard-bookings__status-badge--pending">
                            Menunggu Konfirmasi
                        </span>
                        @elseif($booking->status === 'delivered')
                        <span class="dashboard-bookings__status-badge dashboard-bookings__status-badge--completed">
                            Selesai
                        </span>
                        @else
                        <span class="dashboard-bookings__status-badge dashboard-bookings__status-badge--processing">
                            Dalam Proses
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="dashboard-bookings__pagination">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="dashboard-bookings__empty">
                <div class="dashboard-bookings__empty-icon">
                    <i class="bx bx-package"></i>
                </div>
                <h3 class="dashboard-bookings__empty-title">Belum Ada Booking</h3>
                <p class="dashboard-bookings__empty-text">Anda belum memiliki booking. Mulai dengan membuat booking pertama Anda!</p>
                <div class="dashboard-bookings__empty-actions">
                    <a href="{{ route('booking.create') }}" class="button dashboard-bookings__button--primary">
                        Buat Booking Pertama
                    </a>
                    <a href="{{ route('dashboard') }}" class="button dashboard-bookings__button--secondary">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection