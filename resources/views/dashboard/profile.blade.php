@extends('layouts.app')

@section('title', 'Profile')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endpush

@section('content')
<section class="profile section bd-container">
    <div class="profile__container">
        <!-- Header -->
        <div class="profile__header">
            <h1 class="section-title">Profile Saya</h1>
            <p class="profile__subtitle">Kelola informasi akun Anda</p>
        </div>

        <div class="profile__grid">
            <!-- Profile Form -->
            <div class="profile__main">
                <div class="profile__card">
                    <h2 class="profile__card-title">Informasi Personal</h2>
                    
                    <form method="POST" action="{{ route('dashboard.profile.update') }}" class="profile__form">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name -->
                        <div class="profile__input-group">
                            <label for="name" class="profile__label">Nama Lengkap *</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', auth()->user()->name) }}" 
                                   class="profile__input @error('name') profile__input--error @enderror" 
                                   required>
                            @error('name')
                                <span class="profile__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="profile__input-group">
                            <label for="email" class="profile__label">Email *</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', auth()->user()->email) }}" 
                                   class="profile__input @error('email') profile__input--error @enderror" 
                                   required>
                            @error('email')
                                <span class="profile__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="profile__input-group">
                            <label for="phone" class="profile__label">Nomor Telepon</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', auth()->user()->phone) }}" 
                                   class="profile__input @error('phone') profile__input--error @enderror" 
                                   placeholder="Contoh: 081234567890">
                            @error('phone')
                                <span class="profile__error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="button profile__button">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="profile__sidebar">
                <!-- Account Info -->
                <div class="profile__card">
                    <h3 class="profile__card-title">Informasi Akun</h3>
                    
                    <div class="profile__info-list">
                        <div class="profile__info-item">
                            <p class="profile__info-label">Bergabung Sejak</p>
                            <p class="profile__info-value">{{ auth()->user()->created_at->format('d F Y') }}</p>
                        </div>
                        <div class="profile__info-item">
                            <p class="profile__info-label">Terakhir Login</p>
                            <p class="profile__info-value">{{ now()->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="profile__info-item">
                            <p class="profile__info-label">Status Akun</p>
                            <p class="profile__info-value profile__status--active">Aktif</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="profile__card">
                    <h3 class="profile__card-title">Statistik Booking</h3>
                    
                    @php
                        $user = auth()->user();
                        $userBookings = \App\Models\Booking::whereHas('customer', function($query) use ($user) {
                            $query->where('email', $user->email)
                                  ->orWhere('phone', $user->phone ?? '');
                        })->get();
                        
                        $totalBookings = $userBookings->count();
                        $completedBookings = $userBookings->where('status', 'delivered')->count();
                        $totalSpent = $userBookings->where('payment_status', 'paid')->sum('total_price');
                    @endphp
                    
                    <div class="profile__stats">
                        <div class="profile__stat-item">
                            <div class="profile__stat-number">{{ $totalBookings }}</div>
                            <div class="profile__stat-label">Total Booking</div>
                        </div>
                        <div class="profile__stat-item">
                            <div class="profile__stat-number">{{ $completedBookings }}</div>
                            <div class="profile__stat-label">Selesai</div>
                        </div>
                        <div class="profile__stat-item">
                            <div class="profile__stat-number">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                            <div class="profile__stat-label">Total Pengeluaran</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="profile__card">
                    <h3 class="profile__card-title">Aksi</h3>
                    
                    <div class="profile__actions">
                        <a href="{{ route('dashboard') }}" class="button profile__action-button--primary">
                            Kembali ke Dashboard
                        </a>
                        <a href="{{ route('dashboard.bookings') }}" class="button profile__action-button--secondary">
                            Lihat Semua Booking
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="profile__logout-form">
                            @csrf
                            <button type="submit" class="button profile__action-button--danger">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection