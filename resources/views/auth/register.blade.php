@extends('layouts.app')

@section('title', 'Daftar')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endpush

@section('content')
<section class="auth section bd-container">
    <div class="auth__container">
        <div class="auth__header">
            <h1 class="section-title">Daftar Akun</h1>
            <p class="auth__subtitle">Buat akun baru untuk melacak booking Anda</p>
        </div>

        <div class="auth__form-container">
            <form method="POST" action="{{ route('register') }}" class="auth__form">
                @csrf
                
                <!-- Name -->
                <div class="auth__input-group">
                    <label for="name" class="auth__label">Nama Lengkap *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           class="auth__input @error('name') auth__input--error @enderror" 
                           placeholder="Masukkan nama lengkap Anda"
                           required>
                    @error('name')
                        <span class="auth__error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="auth__input-group">
                    <label for="email" class="auth__label">Email *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           class="auth__input @error('email') auth__input--error @enderror" 
                           placeholder="Masukkan email Anda"
                           required>
                    @error('email')
                        <span class="auth__error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="auth__input-group">
                    <label for="phone" class="auth__label">Nomor Telepon *</label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           class="auth__input @error('phone') auth__input--error @enderror" 
                           placeholder="Contoh: 081234567890"
                           required>
                    @error('phone')
                        <span class="auth__error">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="auth__input-group">
                    <label for="password" class="auth__label">Password *</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="auth__input @error('password') auth__input--error @enderror" 
                           placeholder="Minimal 8 karakter"
                           required>
                    @error('password')
                        <span class="auth__error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="auth__input-group">
                    <label for="password_confirmation" class="auth__label">Konfirmasi Password *</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="auth__input" 
                           placeholder="Ulangi password Anda"
                           required>
                </div>
                
                <button type="submit" class="button auth__button">
                    Daftar
                </button>
            </form>

            <div class="auth__links">
                <p class="auth__link-text">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="auth__link">Login di sini</a>
                </p>
            </div>
        </div>

        <!-- Info Section -->
        <div class="auth__info">
            <h3 class="auth__info-title">Mengapa Daftar?</h3>
            <div class="auth__info-content">
                <ul class="auth__info-list">
                    <li>Kelola semua booking dalam satu tempat</li>
                    <li>Dapatkan notifikasi status booking</li>
                    <li>Riwayat lengkap layanan Anda</li>
                    <li>Proses booking yang lebih cepat</li>
                    <li>Penawaran khusus untuk member</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection