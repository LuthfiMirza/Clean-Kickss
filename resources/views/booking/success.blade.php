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

    <!-- QRIS Payment Section -->
    @if($booking->payment_method === 'qris' && $booking->payment_status !== 'paid')
    <div class="payment-upload-card">
        <h3 style="font-size: 1.3rem; font-weight: 600; color: #d97706; margin-bottom: 1rem;">
            <i class="bx bx-qr"></i> Pembayaran QRIS
        </h3>
        <p style="color: var(--text-color); margin-bottom: 1.5rem;">
            Scan QR Code di bawah ini untuk melakukan pembayaran menggunakan QRIS
        </p>
        
        <!-- QRIS QR Code Display -->
        <div style="background: white; border: 2px solid #f59e0b; border-radius: 1rem; padding: 2rem; margin-bottom: 1.5rem; text-align: center;">
            <div style="background: #fef3c7; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1.5rem;">
                <h4 style="color: #d97706; margin-bottom: 1rem; font-size: 1.1rem; display: flex; align-items: center; justify-content: center;">
                    <i class="bx bx-qr" style="margin-right: 0.5rem; font-size: 1.3rem;"></i>
                    QR Code QRIS
                </h4>
                <div style="background: white; border-radius: 0.5rem; padding: 1.5rem; margin: 1rem auto; display: inline-block; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <img src="{{ asset('assets/img/qris.png') }}" alt="QRIS QR Code" style="width: 200px; height: 200px; display: block;">
                </div>
                <div style="background: white; border-radius: 0.5rem; padding: 1rem; margin-top: 1rem;">
                    <p style="color: #92400e; font-weight: 600; margin-bottom: 0.5rem;">Total Pembayaran:</p>
                    <p style="color: #d97706; font-size: 1.5rem; font-weight: bold; margin: 0;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
            
            <div style="background: #eff6ff; border: 1px solid #3b82f6; border-radius: 0.5rem; padding: 1.5rem; text-align: left;">
                <h5 style="color: #1d4ed8; margin-bottom: 1rem; font-size: 1rem; display: flex; align-items: center;">
                    <i class="bx bx-info-circle" style="margin-right: 0.5rem;"></i>
                    Cara Pembayaran QRIS:
                </h5>
                <ol style="color: var(--text-color); font-size: 0.9rem; margin: 0; padding-left: 1.5rem; line-height: 1.6;">
                    <li>Buka aplikasi mobile banking atau e-wallet Anda (GoPay, OVO, DANA, dll)</li>
                    <li>Pilih menu "Scan QR" atau "QRIS"</li>
                    <li>Arahkan kamera ke QR code di atas</li>
                    <li>Pastikan nominal pembayaran sesuai: <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></li>
                    <li>Konfirmasi pembayaran</li>
                    <li>Simpan bukti pembayaran dan upload di bawah ini</li>
                </ol>
            </div>
            
            <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 0.5rem; padding: 1rem; margin-top: 1rem;">
                <p style="color: #92400e; font-size: 0.9rem; margin: 0; text-align: center;">
                    <i class="bx bx-time" style="margin-right: 0.5rem;"></i>
                    QR Code ini berlaku untuk pembayaran booking ID #{{ $booking->id }}
                </p>
            </div>
        </div>
        
        <!-- Upload Bukti Pembayaran QRIS -->
        <h4 style="color: var(--first-color); margin-bottom: 1rem;">Upload Bukti Pembayaran</h4>
        <p style="color: var(--text-color); margin-bottom: 1.5rem;">
            Setelah melakukan pembayaran QRIS, silakan upload screenshot bukti pembayaran
        </p>
        
        <form action="{{ route('booking.upload.payment.proof', $booking->id) }}" method="POST" enctype="multipart/form-data" id="payment-form">
            @csrf
            <div class="upload-area" id="upload-area" onclick="openFileDialog()">
                <div class="upload-icon">
                    <i class="bx bx-cloud-upload"></i>
                </div>
                <p style="font-weight: 600; color: var(--title-color); margin-bottom: 0.5rem;">Klik untuk memilih file</p>
                <p style="color: var(--text-color); font-size: 0.9rem;">atau drag & drop file di sini</p>
                <p style="color: var(--text-color-light); font-size: 0.8rem; margin-top: 0.5rem;">
                    Format: JPG, PNG, GIF (Max: 2MB)
                </p>
            </div>
            
            <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required style="display: none;" onchange="handleFileSelect(this)">
            
            <div id="preview-container" style="display: none; margin: 1rem 0; text-align: center;">
                <img id="preview-image" class="preview-image" alt="Preview" style="display: block; margin: 0 auto;">
                <p id="file-name" style="margin-top: 0.5rem; font-weight: 600; color: var(--title-color);"></p>
                <button type="button" onclick="removeFile()" style="background: #ef4444; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.25rem; margin-top: 0.5rem; cursor: pointer;">
                    <i class="bx bx-trash"></i> Hapus File
                </button>
            </div>
            
            <button type="submit" class="upload-btn" id="upload-btn" disabled>
                <i class="bx bx-upload"></i> Upload Bukti Pembayaran
            </button>
        </form>
    </div>
    
    <!-- Payment Proof Upload for Non-QRIS -->
    @elseif($booking->payment_method !== 'cash' && $booking->payment_method !== 'qris' && $booking->payment_status !== 'paid')
    <div class="payment-upload-card">
        <h3 style="font-size: 1.3rem; font-weight: 600; color: var(--first-color); margin-bottom: 1rem;">
            <i class="bx bx-upload"></i> Upload Bukti Pembayaran
        </h3>
        <p style="color: var(--text-color); margin-bottom: 1.5rem;">
            Silakan upload bukti pembayaran untuk mempercepat proses konfirmasi booking Anda.
        </p>
        
        <!-- Payment Accounts Card -->
        <div class="payment-accounts-card" style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; padding: 2rem; margin-bottom: 1.5rem; text-align: left;">
            <div class="card-header" style="margin-bottom: 1.5rem;">
                <h4 class="card-title" style="color: var(--first-color); font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center;">
                    @if($booking->payment_method === 'bank_transfer' || $booking->payment_method === 'transfer_bank' || $booking->payment_method === 'bank')
                        <i class="bx bx-building" style="margin-right: 0.5rem; font-size: 1.3rem;"></i>
                        Rekening Bank
                    @elseif($booking->payment_method === 'ewallet' || $booking->payment_method === 'e_wallet' || $booking->payment_method === 'wallet')
                        <i class="bx bx-mobile-alt" style="margin-right: 0.5rem; font-size: 1.3rem;"></i>
                        E-Wallet
                    @else
                        <i class="bx bx-credit-card" style="margin-right: 0.5rem; font-size: 1.3rem;"></i>
                        Informasi Pembayaran
                    @endif
                </h4>
                <span class="account-note" style="color: #64748b; font-size: 0.9rem;">Pilih salah satu untuk transfer</span>
            </div>

            <div class="card-body">
                <!-- E-Wallet Section -->
                @if($booking->payment_method === 'ewallet' || $booking->payment_method === 'e_wallet' || $booking->payment_method === 'wallet')
                    <div class="accounts-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
                        <!-- GoPay -->
                        <div class="account-card wallet-account" style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; position: relative;">
                            <div class="account-header" style="display: flex; align-items: center; margin-bottom: 1rem;">
                                <div class="wallet-logo" style="width: 40px; height: 40px; background: #00aa13; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                    <i class="bx bx-mobile-alt" style="color: white; font-size: 1.2rem;"></i>
                                </div>
                                <div class="wallet-name" style="font-weight: 600; color: var(--title-color); font-size: 1.1rem;">GoPay</div>
                            </div>
                            <div class="account-details" style="margin-bottom: 1rem;">
                                <div class="wallet-number" style="font-family: monospace; font-size: 1.1rem; font-weight: 700; color: var(--first-color);">081543425338</div>
                            </div>
                            <button class="copy-btn" onclick="copyToClipboard('081543425338', 'Nomor GoPay berhasil disalin!')" style="position: absolute; top: 1rem; right: 1rem; background: var(--first-color); color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; gap: 0.3rem;">
                                <i class="bx bx-copy"></i>
                                <span>Salin</span>
                            </button>
                        </div>

                        <!-- OVO -->
                        <div class="account-card wallet-account" style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; position: relative;">
                            <div class="account-header" style="display: flex; align-items: center; margin-bottom: 1rem;">
                                <div class="wallet-logo" style="width: 40px; height: 40px; background: #4c3494; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                    <i class="bx bx-mobile-alt" style="color: white; font-size: 1.2rem;"></i>
                                </div>
                                <div class="wallet-name" style="font-weight: 600; color: var(--title-color); font-size: 1.1rem;">OVO</div>
                            </div>
                            <div class="account-details" style="margin-bottom: 1rem;">
                                <div class="wallet-number" style="font-family: monospace; font-size: 1.1rem; font-weight: 700; color: var(--first-color);">081543425338</div>
                            </div>
                            <button class="copy-btn" onclick="copyToClipboard('081543425338', 'Nomor OVO berhasil disalin!')" style="position: absolute; top: 1rem; right: 1rem; background: var(--first-color); color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; gap: 0.3rem;">
                                <i class="bx bx-copy"></i>
                                <span>Salin</span>
                            </button>
                        </div>

                        <!-- DANA -->
                        <div class="account-card wallet-account" style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; position: relative;">
                            <div class="account-header" style="display: flex; align-items: center; margin-bottom: 1rem;">
                                <div class="wallet-logo" style="width: 40px; height: 40px; background: #118eea; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                    <i class="bx bx-mobile-alt" style="color: white; font-size: 1.2rem;"></i>
                                </div>
                                <div class="wallet-name" style="font-weight: 600; color: var(--title-color); font-size: 1.1rem;">DANA</div>
                            </div>
                            <div class="account-details" style="margin-bottom: 1rem;">
                                <div class="wallet-number" style="font-family: monospace; font-size: 1.1rem; font-weight: 700; color: var(--first-color);">081543425338</div>
                            </div>
                            <button class="copy-btn" onclick="copyToClipboard('081543425338', 'Nomor DANA berhasil disalin!')" style="position: absolute; top: 1rem; right: 1rem; background: var(--first-color); color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; gap: 0.3rem;">
                                <i class="bx bx-copy"></i>
                                <span>Salin</span>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Payment Instructions -->
                <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 0.5rem; padding: 1rem; margin-top: 1.5rem;">
                    <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                        <i class="bx bx-info-circle" style="color: #d97706; margin-right: 0.5rem; font-size: 1.1rem;"></i>
                        <strong style="color: #92400e;">Petunjuk Pembayaran:</strong>
                    </div>
                    <ul style="margin: 0; padding-left: 1.5rem; color: #92400e; font-size: 0.9rem;">
                        <li>Transfer sesuai dengan total pembayaran: <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></li>
                        <li>Gunakan salah satu rekening/nomor di atas</li>
                        <li>Simpan bukti transfer untuk diupload</li>
                        <li>Upload bukti pembayaran di bawah ini</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <form action="{{ route('booking.upload.payment.proof', $booking->id) }}" method="POST" enctype="multipart/form-data" id="payment-form">
            @csrf
            <div class="upload-area" id="upload-area" onclick="openFileDialog()">
                <div class="upload-icon">
                    <i class="bx bx-cloud-upload"></i>
                </div>
                <p style="font-weight: 600; color: var(--title-color); margin-bottom: 0.5rem;">Klik untuk memilih file</p>
                <p style="color: var(--text-color); font-size: 0.9rem;">atau drag & drop file di sini</p>
                <p style="color: var(--text-color-light); font-size: 0.8rem; margin-top: 0.5rem;">
                    Format: JPG, PNG, GIF (Max: 2MB)
                </p>
            </div>
            
            <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required style="display: none;" onchange="handleFileSelect(this)">
            
            <div id="preview-container" style="display: none; margin: 1rem 0; text-align: center;">
                <img id="preview-image" class="preview-image" alt="Preview" style="display: block; margin: 0 auto;">
                <p id="file-name" style="margin-top: 0.5rem; font-weight: 600; color: var(--title-color);"></p>
                <button type="button" onclick="removeFile()" style="background: #ef4444; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.25rem; margin-top: 0.5rem; cursor: pointer;">
                    <i class="bx bx-trash"></i> Hapus File
                </button>
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

    <!-- Contact Info -->
    <div class="contact-info">
        <p style="margin-bottom: 0.5rem;">Butuh bantuan? Hubungi kami:</p>
        <p style="font-weight: 600; color: var(--title-color);">WhatsApp: +62 815-4342-5338</p>
        <p style="font-weight: 600; color: var(--title-color);">Email: sevatoo@gmail.com</p>
    </div>
</section>

<script>
// Simple file upload functionality
function openFileDialog() {
    document.getElementById('payment_proof').click();
}

function handleFileSelect(input) {
    const file = input.files[0];
    if (!file) return;

    console.log('File selected:', file.name, file.type, file.size);
    
    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 2MB.');
        input.value = '';
        return;
    }

    // Validate file type
    if (!file.type.startsWith('image/')) {
        alert('File harus berupa gambar.');
        input.value = '';
        return;
    }

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview-image').src = e.target.result;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('preview-container').style.display = 'block';
        document.getElementById('upload-btn').disabled = false;
        
        // Scroll to preview
        setTimeout(() => {
            document.getElementById('preview-container').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }, 100);
    };
    reader.readAsDataURL(file);
}

function removeFile() {
    document.getElementById('payment_proof').value = '';
    document.getElementById('preview-container').style.display = 'none';
    document.getElementById('upload-btn').disabled = true;
    document.getElementById('preview-image').src = '';
    document.getElementById('file-name').textContent = '';
}

// Copy to clipboard function
function copyToClipboard(text, message) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    textarea.setSelectionRange(0, 99999);
    
    try {
        document.execCommand('copy');
        
        if (message) {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #10b981;
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                font-weight: 600;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
        }
    } catch (err) {
        alert('Gagal menyalin. Silakan salin secara manual: ' + text);
    }
    
    document.body.removeChild(textarea);
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('payment_proof');
    
    if (uploadArea && fileInput) {
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
                handleFileSelect(fileInput);
            }
        });
    }
});
</script>
@endsection