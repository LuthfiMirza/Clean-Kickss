@extends('layouts.app')

@section('title', 'Login')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endpush

@section('content')
<section class="auth section bd-container">
    <div class="auth__container">
        <div class="auth__header">
            <h1 class="section-title">Login</h1>
            <p class="auth__subtitle">Masuk ke akun Anda untuk melacak booking</p>
        </div>

        <div class="auth__form-container">
            <form method="POST" action="{{ route('login') }}" class="auth__form">
                @csrf
                
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
                
                <!-- Password -->
                <div class="auth__input-group">
                    <label for="password" class="auth__label">Password *</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="auth__input @error('password') auth__input--error @enderror" 
                           placeholder="Masukkan password Anda"
                           required>
                    @error('password')
                        <span class="auth__error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="auth__checkbox-group">
                    <label class="auth__checkbox-label">
                        <input type="checkbox" name="remember" class="auth__checkbox">
                        <span class="auth__checkbox-text">Ingat saya</span>
                    </label>
                </div>
                
                <button type="submit" class="button auth__button">
                    Login
                </button>
            </form>

            <div class="auth__links">
                <p class="auth__link-text">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="auth__link">Daftar di sini</a>
                </p>
            </div>
        </div>

        <!-- Info Section -->
        <div class="auth__info">
            <h3 class="auth__info-title">Keuntungan Login</h3>
            <div class="auth__info-content">
                <ul class="auth__info-list">
                    <li>Lacak semua booking Anda dengan mudah</li>
                    <li>Riwayat lengkap layanan cuci sepatu</li>
                    <li>Notifikasi status booking real-time</li>
                    <li>Booking lebih cepat dengan data tersimpan</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection