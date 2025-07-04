@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endpush

@section('content')
<section class="dashboard section bd-container">
    <div class="dashboard__container">
        <!-- Header -->
        <div class="dashboard__header">
            <div class="dashboard__welcome">
                <h1 class="section-title">Selamat Datang, {{ $user->name }}!</h1>
                <p class="dashboard__subtitle">Kelola dan lacak semua booking cuci sepatu Anda</p>
                
                
            </div>
            <div class="dashboard__actions">
                <a href="{{ route('booking.create') }}" class="button dashboard__button--primary">
                    Booking Baru
                </a>
                <a href="{{ route('dashboard.profile') }}" class="button dashboard__button--secondary">
                    Profile
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="dashboard__stats">
            <div class="dashboard__stat-card">
                <div class="dashboard__stat-icon dashboard__stat-icon--total">
                    <i class="bx bx-list-ul"></i>
                </div>
                <div class="dashboard__stat-info">
                    <h3 class="dashboard__stat-number">{{ $totalBookings }}</h3>
                    <p class="dashboard__stat-label">Total Booking</p>
                </div>
            </div>
            
            <div class="dashboard__stat-card">
                <div class="dashboard__stat-icon dashboard__stat-icon--pending">
                    <i class="bx bx-time"></i>
                </div>
                <div class="dashboard__stat-info">
                    <h3 class="dashboard__stat-number">{{ $pendingBookings }}</h3>
                    <p class="dashboard__stat-label">Menunggu Konfirmasi</p>
                </div>
            </div>
            
            <div class="dashboard__stat-card">
                <div class="dashboard__stat-icon dashboard__stat-icon--active">
                    <i class="bx bx-loader-alt"></i>
                </div>
                <div class="dashboard__stat-info">
                    <h3 class="dashboard__stat-number">{{ $activeBookings }}</h3>
                    <p class="dashboard__stat-label">Sedang Proses</p>
                </div>
            </div>
            
            <div class="dashboard__stat-card">
                <div class="dashboard__stat-icon dashboard__stat-icon--completed">
                    <i class="bx bx-check-circle"></i>
                </div>
                <div class="dashboard__stat-info">
                    <h3 class="dashboard__stat-number">{{ $completedBookings }}</h3>
                    <p class="dashboard__stat-label">Selesai</p>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="dashboard__section">
            <div class="dashboard__section-header">
                <h2 class="dashboard__section-title">Booking Terbaru</h2>
                <a href="{{ route('dashboard.bookings') }}" class="dashboard__section-link">
                    Lihat Semua
                </a>
            </div>

            @if($bookings->count() > 0)
                <div class="dashboard__bookings">
                    @foreach($bookings->take(5) as $booking)
                    <div class="dashboard__booking-card">
                        <div class="dashboard__booking-header">
                            <div class="dashboard__booking-info">
                                <h3 class="dashboard__booking-title">Booking #{{ $booking->id }}</h3>
                                <p class="dashboard__booking-service">{{ $booking->service->name }}</p>
                                <p class="dashboard__booking-date">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="dashboard__booking-status">
                                @php
                                $statusClasses = [
                                'pending' => 'dashboard__status--pending',
                                'confirmed' => 'dashboard__status--confirmed',
                                'picked_up' => 'dashboard__status--picked',
                                'in_progress' => 'dashboard__status--processing',
                                'ready' => 'dashboard__status--ready',
                                'delivered' => 'dashboard__status--completed',
                                'cancelled' => 'dashboard__status--cancelled'
                                ];
                                $statusClass = $statusClasses[$booking->status] ?? 'dashboard__status--default';
                                
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
                                <span class="dashboard__status {{ $statusClass }}">
                                    {{ $statusLabels[$booking->status] ?? ucwords(str_replace('_', ' ', $booking->status)) }}
                                </span>
                                <p class="dashboard__booking-price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="dashboard__booking-actions">
                            <a href="{{ route('booking.show', $booking->id) }}" class="button dashboard__booking-button">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="dashboard__empty">
                    <div class="dashboard__empty-icon">
                        <i class="bx bx-package"></i>
                    </div>
                    <h3 class="dashboard__empty-title">Belum Ada Booking</h3>
                    <p class="dashboard__empty-text">Tidak ada booking yang ditemukan. Mungkin Anda sudah pernah booking dengan nomor telepon yang berbeda?</p>
                    
                    <!-- Search for existing bookings -->
                    <div class="dashboard__search-section">
                        <h4 class="dashboard__search-title">Cari Booking Lama</h4>
                        <p class="dashboard__search-desc">Masukkan nomor telepon yang pernah Anda gunakan untuk booking:</p>
                        
                        <form id="searchBookingsForm" class="dashboard__search-form">
                            @csrf
                            <div class="dashboard__search-input-group">
                                <input type="tel" 
                                       id="searchPhone" 
                                       name="phone" 
                                       class="dashboard__search-input" 
                                       placeholder="Contoh: 081234567890"
                                       required>
                                <button type="submit" class="button dashboard__search-button">
                                    Cari Booking
                                </button>
                            </div>
                        </form>
                        
                        <div id="searchResults" class="dashboard__search-results" style="display: none;">
                            <!-- Results will be populated by JavaScript -->
                        </div>
                    </div>
                    
                    <div class="dashboard__empty-actions">
                        <a href="{{ route('booking.create') }}" class="button dashboard__empty-button">
                            Buat Booking Baru
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="dashboard__section">
            <h2 class="dashboard__section-title">Aksi Cepat</h2>
            <div class="dashboard__quick-actions">
                <a href="{{ route('booking.create') }}" class="dashboard__quick-action">
                    <div class="dashboard__quick-action-icon">
                        <i class="bx bx-plus"></i>
                    </div>
                    <h3 class="dashboard__quick-action-title">Booking Baru</h3>
                    <p class="dashboard__quick-action-desc">Buat booking cuci sepatu baru</p>
                </a>
                
                <a href="{{ route('dashboard.bookings') }}" class="dashboard__quick-action">
                    <div class="dashboard__quick-action-icon">
                        <i class="bx bx-list-ul"></i>
                    </div>
                    <h3 class="dashboard__quick-action-title">Semua Booking</h3>
                    <p class="dashboard__quick-action-desc">Lihat riwayat booking lengkap</p>
                </a>
                
                <a href="{{ route('dashboard.profile') }}" class="dashboard__quick-action">
                    <div class="dashboard__quick-action-icon">
                        <i class="bx bx-user"></i>
                    </div>
                    <h3 class="dashboard__quick-action-title">Profile</h3>
                    <p class="dashboard__quick-action-desc">Kelola informasi akun Anda</p>
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchBookingsForm');
    const searchResults = document.getElementById('searchResults');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const searchButton = this.querySelector('.dashboard__search-button');
            const originalText = searchButton.textContent;
            
            // Show loading state
            searchButton.textContent = 'Mencari...';
            searchButton.disabled = true;
            
            fetch('{{ route("dashboard.search.bookings") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displaySearchResults(data.bookings, data.message);
                } else {
                    alert('Terjadi kesalahan saat mencari booking');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mencari booking');
            })
            .finally(() => {
                // Reset button state
                searchButton.textContent = originalText;
                searchButton.disabled = false;
            });
        });
    }
    
    function displaySearchResults(bookings, message) {
        const resultsDiv = document.getElementById('searchResults');
        
        if (bookings.length === 0) {
            resultsDiv.innerHTML = `
                <div class="dashboard__search-message">
                    <p>${message}</p>
                </div>
            `;
        } else {
            let resultsHTML = `<div class="dashboard__search-message"><p>${message}</p></div>`;
            
            bookings.forEach(booking => {
                const statusLabels = {
                    'pending': 'Menunggu Konfirmasi',
                    'confirmed': 'Dikonfirmasi',
                    'picked_up': 'Sudah Diambil',
                    'in_progress': 'Sedang Dikerjakan',
                    'ready': 'Siap Diantar',
                    'delivered': 'Sudah Diantar',
                    'cancelled': 'Dibatalkan'
                };
                
                const statusLabel = statusLabels[booking.status] || booking.status;
                const bookingDate = new Date(booking.created_at).toLocaleDateString('id-ID');
                
                resultsHTML += `
                    <div class="dashboard__search-result-item">
                        <div class="dashboard__search-result-info">
                            <div class="dashboard__search-result-title">Booking #${booking.id} - ${booking.service.name}</div>
                            <div class="dashboard__search-result-details">
                                Status: ${statusLabel} | Tanggal: ${bookingDate} | Customer: ${booking.customer.name}
                            </div>
                        </div>
                        <div class="dashboard__search-result-actions">
                            <button onclick="connectBookings('${booking.customer.phone}')" class="dashboard__connect-button">
                                Hubungkan ke Akun
                            </button>
                        </div>
                    </div>
                `;
            });
            
            resultsDiv.innerHTML = resultsHTML;
        }
        
        resultsDiv.style.display = 'block';
    }
    
    // Make connectBookings function global
    window.connectBookings = function(phone) {
        if (confirm('Apakah Anda yakin ingin menghubungkan booking dengan nomor telepon ' + phone + ' ke akun Anda?')) {
            const formData = new FormData();
            formData.append('phone', phone);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch('{{ route("dashboard.update.phone") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Terjadi kesalahan saat menghubungkan booking');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghubungkan booking');
            });
        }
    };
});
</script>
@endpush
@endsection