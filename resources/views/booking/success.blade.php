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
    
    .payment-upload-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 2px dashed var(--first-color);
        border-radius: 1rem;
        padding: 2rem;
        margin: 2rem 0;
        text-align: center;
    }
    
    .payment-upload-card.has-proof {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-color: #10b981;
    }
    
    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 0.5rem;
        padding: 2rem;
        margin: 1rem 0;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .upload-area:hover {
        border-color: var(--first-color);
        background: rgba(var(--first-color-rgb), 0.05);
    }
    
    .upload-area.dragover {
        border-color: var(--first-color);
        background: rgba(var(--first-color-rgb), 0.1);
    }
    
    .upload-icon {
        font-size: 3rem;
        color: var(--first-color);
        margin-bottom: 1rem;
    }
    
    .file-input {
        display: none;
    }
    
    .upload-btn {
        background: var(--first-color);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .upload-btn:hover {
        background: var(--first-color-alt);
        transform: translateY(-2px);
    }
    
    .upload-btn:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
    }
    
    .preview-image {
        max-width: 300px;
        max-height: 200px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 1rem auto;
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
    
    .status-badge.paid {
        background: #d1fae5;
        color: #065f46;
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
    
    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
    
    @media (max-width: 768px) {
        .success-hero {
            padding: 2rem 0;
        }
        
        .booking-details-card, .payment-upload-card {
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
        
        .upload-area {
            padding: 1.5rem;
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

<!-- Main Content -->
<section class="section bd-container">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Booking Details -->
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
            <span class="detail-label">Status Pembayaran:</span>
            <span class="status-badge {{ $booking->payment_status === 'paid' ? 'paid' : '' }}">{{ $booking->payment_status_label }}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Status Booking:</span>
            <span class="status-badge">{{ $booking->status_label }}</span>
        </div>
        
        @if($booking->notes)
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f3f4f6;">
            <span class="detail-label" style="display: block; margin-bottom: 0.5rem;">Catatan:</span>
            <p style="color: var(--title-color);">{{ $booking->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Payment Proof Upload -->
    @if($booking->payment_method !== 'cash' && $booking->payment_status !== 'paid')
    <div class="payment-upload-card">
        <h3 style="font-size: 1.3rem; font-weight: 600; color: var(--first-color); margin-bottom: 1rem;">
            <i class="bx bx-upload"></i> Upload Bukti Pembayaran
        </h3>
        <p style="color: var(--text-color); margin-bottom: 1.5rem;">
            Silakan upload bukti pembayaran untuk mempercepat proses konfirmasi booking Anda.
        </p>
        
        <form action="{{ route('booking.upload.payment.proof', $booking->id) }}" method="POST" enctype="multipart/form-data" id="payment-form">
            @csrf
            <div class="upload-area" onclick="document.getElementById('payment_proof').click()">
                <div class="upload-icon">
                    <i class="bx bx-cloud-upload"></i>
                </div>
                <p style="font-weight: 600; color: var(--title-color); margin-bottom: 0.5rem;">Klik untuk memilih file</p>
                <p style="color: var(--text-color); font-size: 0.9rem;">atau drag & drop file di sini</p>
                <p style="color: var(--text-color-light); font-size: 0.8rem; margin-top: 0.5rem;">
                    Format: JPG, PNG, GIF (Max: 2MB)
                </p>
            </div>
            
            <input type="file" id="payment_proof" name="payment_proof" class="file-input" accept="image/*" required>
            
            <div id="preview-container" style="display: none; margin: 1rem 0;">
                <img id="preview-image" class="preview-image" alt="Preview">
                <p id="file-name" style="margin-top: 0.5rem; font-weight: 600; color: var(--title-color);"></p>
            </div>
            
            <button type="submit" class="upload-btn" id="upload-btn" disabled>
                <i class="bx bx-upload"></i> Upload Bukti Pembayaran
            </button>
        </form>
    </div>
    @elseif($booking->payment_proof)
    <div class="payment-upload-card has-proof">
        <h3 style="font-size: 1.3rem; font-weight: 600; color: #10b981; margin-bottom: 1rem;">
            <i class="bx bx-check-circle"></i> Bukti Pembayaran Telah Diupload
        </h3>
        <p style="color: var(--text-color); margin-bottom: 1rem;">
            Bukti pembayaran Anda telah berhasil diupload dan sedang dalam proses verifikasi.
        </p>
        <img src="{{ $booking->payment_proof_url }}" alt="Bukti Pembayaran" class="preview-image">
        <p style="color: var(--text-color-light); font-size: 0.9rem; margin-top: 1rem;">
            Kami akan memverifikasi pembayaran Anda dalam 1-2 jam kerja.
        </p>
    </div>
    @endif

    <!-- Next Steps -->
    <div class="steps-card">
        <h3 style="font-size: 1.2rem; font-weight: 600; color: var(--first-color); margin-bottom: 1rem;">Langkah Selanjutnya:</h3>
        <div class="step-item">
            <span class="step-number">1</span>
            <span style="color: var(--text-color);">
                @if($booking->payment_method !== 'cash')
                    Upload bukti pembayaran untuk mempercepat konfirmasi
                @else
                    Kami akan menghubungi Anda dalam 1-2 jam untuk konfirmasi booking
                @endif
            </span>
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

    <!-- WhatsApp Confirmation -->
    <div style="background: linear-gradient(135deg, #25d366 0%, #128c7e 100%); color: white; padding: 2rem; border-radius: 1rem; margin: 2rem 0; text-align: center;">
        <h3 style="margin-bottom: 1rem; font-size: 1.3rem;">
            <i class="bx bxl-whatsapp" style="font-size: 1.5rem; margin-right: 0.5rem;"></i>
            Konfirmasi WhatsApp Otomatis
        </h3>
        <p style="margin-bottom: 1.5rem; opacity: 0.9;">
            Kami akan mengirimkan konfirmasi booking ke WhatsApp Anda dalam beberapa menit
        </p>
        <a href="https://wa.me/6281543425338?text=Halo,%20saya%20baru%20saja%20membuat%20booking%20dengan%20ID%20%23{{ $booking->id }}%20untuk%20layanan%20{{ urlencode($booking->service->name) }}.%20Mohon%20konfirmasinya.%20Terima%20kasih!" 
           target="_blank" 
           style="background: rgba(255,255,255,0.2); color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; display: inline-block; transition: all 0.3s ease; font-weight: 600;">
            <i class="bx bxl-whatsapp"></i> Hubungi via WhatsApp
        </a>
    </div>

    <!-- Auto Refresh Status -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1.5rem; margin: 2rem 0; text-align: center;">
        <h4 style="color: var(--first-color); margin-bottom: 1rem;">
            <i class="bx bx-refresh"></i> Status Auto Update
        </h4>
        <p style="color: var(--text-color); margin-bottom: 1rem;">
            Halaman ini akan otomatis refresh setiap 30 detik untuk update status terbaru
        </p>
        <div style="display: flex; align-items: center; justify-content: center; gap: 1rem;">
            <span style="color: var(--text-color-light); font-size: 0.9rem;">Refresh berikutnya dalam:</span>
            <span id="countdown" style="background: var(--first-color); color: white; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-weight: 600; min-width: 3rem; text-align: center;">30</span>
            <span style="color: var(--text-color-light); font-size: 0.9rem;">detik</span>
            <button onclick="refreshPage()" style="background: transparent; border: 1px solid var(--first-color); color: var(--first-color); padding: 0.25rem 0.75rem; border-radius: 0.25rem; cursor: pointer; font-size: 0.8rem;">
                <i class="bx bx-refresh"></i> Refresh Sekarang
            </button>
        </div>
    </div>

    <!-- Contact Info -->
    <div class="contact-info">
        <p style="margin-bottom: 0.5rem;">Butuh bantuan? Hubungi kami:</p>
        <p style="font-weight: 600; color: var(--title-color);">WhatsApp: 081543425338</p>
        <p style="font-weight: 600; color: var(--title-color);">Email: sevatoo@gmail.com</p>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('payment_proof');
    const uploadBtn = document.getElementById('upload-btn');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const fileName = document.getElementById('file-name');
    const uploadArea = document.querySelector('.upload-area');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    fileInput.value = '';
                    return;
                }

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar.');
                    fileInput.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    fileName.textContent = file.name;
                    previewContainer.style.display = 'block';
                    uploadBtn.disabled = false;
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop functionality
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });
    }

    // Auto refresh functionality
    let countdown = 30;
    const countdownElement = document.getElementById('countdown');
    
    function updateCountdown() {
        countdownElement.textContent = countdown;
        countdown--;
        
        if (countdown < 0) {
            refreshPage();
        }
    }
    
    // Update countdown every second
    const countdownInterval = setInterval(updateCountdown, 1000);
    
    // Auto refresh after 30 seconds
    const refreshTimeout = setTimeout(function() {
        refreshPage();
    }, 30000);
    
    // Clear intervals when page is about to unload
    window.addEventListener('beforeunload', function() {
        clearInterval(countdownInterval);
        clearTimeout(refreshTimeout);
    });
    
    // Send WhatsApp notification automatically
    setTimeout(function() {
        sendWhatsAppNotification();
    }, 2000); // Send after 2 seconds
});

function refreshPage() {
    window.location.reload();
}

function sendWhatsAppNotification() {
    // This would typically be handled by a backend service
    // For now, we'll just show a notification that WhatsApp message would be sent
    console.log('WhatsApp notification would be sent to customer');
    
    // You could implement actual WhatsApp API integration here
    // For example, using WhatsApp Business API or a service like Twilio
}

// Pause auto-refresh when user is interacting with the page
let userActive = true;
let inactivityTimer;

function resetInactivityTimer() {
    userActive = true;
    clearTimeout(inactivityTimer);
    inactivityTimer = setTimeout(function() {
        userActive = false;
    }, 5000); // Consider user inactive after 5 seconds
}

// Track user activity
document.addEventListener('mousemove', resetInactivityTimer);
document.addEventListener('keypress', resetInactivityTimer);
document.addEventListener('scroll', resetInactivityTimer);
document.addEventListener('click', resetInactivityTimer);

// Initialize inactivity timer
resetInactivityTimer();
</script>
@endsection