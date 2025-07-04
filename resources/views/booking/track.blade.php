@extends('layouts.app')

@section('title', 'Lacak Booking')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endpush

@section('content')
<section class="track section bd-container">
    <div class="track__container">
        <div class="track__header">
            <h2 class="section-title">Lacak Booking</h2>
            <p class="track__subtitle">Masukkan nomor telepon untuk melihat status booking Anda</p>
        </div>

        <div class="track__form-container">
            <form action="{{ route('booking.track.result') }}" method="POST" class="track__form">
                @csrf
                
                <div class="track__input-group">
                    <label for="phone" class="track__label">Nomor Telepon *</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" 
                           class="track__input" 
                           placeholder="Contoh: 081234567890" required>
                </div>
                
                <div class="track__input-group">
                    <label for="booking_id" class="track__label">ID Booking (Opsional)</label>
                    <input type="text" id="booking_id" name="booking_id" value="{{ old('booking_id') }}" 
                           class="track__input" 
                           placeholder="Contoh: 123">
                    <p class="track__help-text">Kosongkan untuk melihat semua booking</p>
                </div>
                
                <button type="submit" class="button track__button">
                    Lacak Booking
                </button>
            </form>
        </div>

        <!-- Help Section -->
        <div class="track__help">
            <h3 class="track__help-title">Bantuan</h3>
            <div class="track__help-content">
                <p class="track__help-subtitle"><strong>Cara melacak:</strong></p>
                <ul class="track__help-list">
                    <li>Masukkan nomor telepon yang digunakan saat booking</li>
                    <li>ID Booking bisa ditemukan di email konfirmasi atau SMS</li>
                    <li>Jika lupa ID Booking, kosongkan saja untuk melihat semua booking</li>
                </ul>
            </div>
        </div>

        <!-- Status Legend -->
        <div class="track__status-legend">
            <h3 class="track__status-title">Status Booking</h3>
            <div class="track__status-list">
                <div class="track__status-item">
                    <span class="track__status-badge track__status-badge--pending">Menunggu Konfirmasi</span>
                    <span class="track__status-desc">Booking baru, menunggu konfirmasi dari tim</span>
                </div>
                <div class="track__status-item">
                    <span class="track__status-badge track__status-badge--confirmed">Dikonfirmasi</span>
                    <span class="track__status-desc">Booking dikonfirmasi, siap untuk pickup</span>
                </div>
                <div class="track__status-item">
                    <span class="track__status-badge track__status-badge--picked">Sudah Diambil</span>
                    <span class="track__status-desc">Sepatu sudah diambil dari lokasi</span>
                </div>
                <div class="track__status-item">
                    <span class="track__status-badge track__status-badge--processing">Sedang Dikerjakan</span>
                    <span class="track__status-desc">Sepatu sedang dalam proses pembersihan</span>
                </div>
                <div class="track__status-item">
                    <span class="track__status-badge track__status-badge--ready">Siap Diantar</span>
                    <span class="track__status-desc">Sepatu selesai, siap untuk diantar</span>
                </div>
                <div class="track__status-item">
                    <span class="track__status-badge track__status-badge--completed">Sudah Diantar</span>
                    <span class="track__status-desc">Sepatu sudah diantar ke pelanggan</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection