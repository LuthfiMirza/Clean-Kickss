@extends('layouts.app')

@section('title', 'Hasil Pelacakan Booking')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endpush

@section('content')
<section class="track-result section bd-container">
    <div class="track-result__container">
        <div class="track-result__header">
            <h1 class="section-title">Hasil Pelacakan Booking</h1>
            <p class="track-result__subtitle">Ditemukan {{ $bookings->count() }} booking</p>
        </div>

        @if($bookings->count() > 0)
            <div class="track-result__list">
                @foreach($bookings as $booking)
                <div class="track-result__card">
                    <div class="track-result__card-header">
                        <div class="track-result__booking-info">
                            <h3 class="track-result__booking-title">Booking #{{ $booking->id }}</h3>
                            <p class="track-result__service-name">{{ $booking->service->name }}</p>
                        </div>
                        <div class="track-result__status-info">
                            @php
                                $statusClasses = [
                                    'pending' => 'track-result__status--pending',
                                    'confirmed' => 'track-result__status--confirmed',
                                    'picked_up' => 'track-result__status--picked',
                                    'in_progress' => 'track-result__status--processing',
                                    'ready' => 'track-result__status--ready',
                                    'delivered' => 'track-result__status--completed',
                                    'cancelled' => 'track-result__status--cancelled'
                                ];
                                $statusClass = $statusClasses[$booking->status] ?? 'track-result__status--default';
                                
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
                            <span class="track-result__status {{ $statusClass }}">
                                {{ $statusLabels[$booking->status] ?? ucwords(str_replace('_', ' ', $booking->status)) }}
                            </span>
                            <p class="track-result__date">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="track-result__details">
                        <div class="track-result__detail-item">
                            <p class="track-result__detail-label">Tanggal Booking</p>
                            <p class="track-result__detail-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</p>
                        </div>
                        <div class="track-result__detail-item">
                            <p class="track-result__detail-label">Waktu Pickup</p>
                            <p class="track-result__detail-value">{{ \Carbon\Carbon::parse($booking->pickup_time)->format('H:i') }}</p>
                        </div>
                        <div class="track-result__detail-item">
                            <p class="track-result__detail-label">Total Harga</p>
                            <p class="track-result__detail-value track-result__price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="track-result__detail-item">
                            <p class="track-result__detail-label">Pembayaran</p>
                            @php
                                $paymentClasses = [
                                    'pending' => 'track-result__payment--unpaid',
                                    'paid' => 'track-result__payment--paid',
                                    'refunded' => 'track-result__payment--refunded'
                                ];
                                $paymentClass = $paymentClasses[$booking->payment_status] ?? 'track-result__payment--default';
                                
                                $paymentLabels = [
                                    'pending' => 'Belum Bayar',
                                    'paid' => 'Sudah Bayar',
                                    'refunded' => 'Dikembalikan'
                                ];
                            @endphp
                            <p class="track-result__detail-value {{ $paymentClass }}">{{ $paymentLabels[$booking->payment_status] ?? ucwords(str_replace('_', ' ', $booking->payment_status)) }}</p>
                        </div>
                    </div>

                    @if($booking->delivery_time)
                    <div class="track-result__extra-info">
                        <p class="track-result__detail-label">Waktu Delivery</p>
                        <p class="track-result__detail-value">{{ \Carbon\Carbon::parse($booking->delivery_time)->format('H:i') }}</p>
                    </div>
                    @endif

                    @if($booking->notes)
                    <div class="track-result__extra-info">
                        <p class="track-result__detail-label">Catatan</p>
                        <p class="track-result__detail-value">{{ $booking->notes }}</p>
                    </div>
                    @endif

                    <!-- Progress Bar -->
                    <div class="track-result__progress">
                        <div class="track-result__progress-header">
                            <span class="track-result__progress-label">Progress</span>
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
                            <span class="track-result__progress-percentage">{{ $progress }}%</span>
                        </div>
                        <div class="track-result__progress-bar">
                            <div class="track-result__progress-fill" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <div class="track-result__actions">
                        <a href="{{ route('booking.show', $booking->id) }}" class="button track-result__button--primary">
                            Lihat Detail
                        </a>
                        @if($booking->status === 'pending')
                        <span class="track-result__status-badge track-result__status-badge--pending">
                            Menunggu Konfirmasi
                        </span>
                        @elseif($booking->status === 'delivered')
                        <span class="track-result__status-badge track-result__status-badge--completed">
                            Selesai
                        </span>
                        @else
                        <span class="track-result__status-badge track-result__status-badge--processing">
                            Dalam Proses
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="track-result__empty">
                <div class="track-result__empty-icon">
                    <svg class="track-result__empty-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="track-result__empty-title">Tidak Ada Booking Ditemukan</h3>
                <p class="track-result__empty-text">Tidak ada booking yang ditemukan dengan nomor telepon tersebut.</p>
                <div class="track-result__empty-actions">
                    <a href="{{ route('booking.track') }}" class="button track-result__button--primary">
                        Coba Lagi
                    </a>
                    <a href="{{ route('booking.create') }}" class="button track-result__button--success">
                        Buat Booking Baru
                    </a>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="track-result__footer">
            <div class="track-result__footer-actions">
                <a href="{{ route('booking.track') }}" class="button track-result__button--secondary">
                    Lacak Lagi
                </a>
                <a href="{{ route('booking.create') }}" class="button track-result__button--success">
                    Booking Baru
                </a>
                <a href="{{ route('home') }}" class="button track-result__button--primary">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>
@endsection