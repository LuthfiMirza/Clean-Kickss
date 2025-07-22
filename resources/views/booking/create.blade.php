@extends('layouts.app')

@section('title', 'Buat Booking Baru')

@push('styles')
<style>
    .booking-form {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin: 2rem auto;
        max-width: 800px;
    }
    
    .user-info-banner {
        background: linear-gradient(135deg, var(--first-color) 0%, var(--first-color-alt) 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .user-details h3 {
        margin: 0 0 0.25rem 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .user-details p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    
    .form-section h2 {
        color: var(--title-color);
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--first-color);
        display: inline-block;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--title-color);
    }
    
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: border-color 0.3s ease;
        background: white;
    }
    
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--first-color);
    }
    
    .form-input.pre-filled {
        background: #f8fafc;
        border-color: var(--first-color);
    }
    
    .service-option {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .service-option:hover {
        border-color: var(--first-color);
        background: rgba(var(--first-color-rgb), 0.05);
    }
    
    .service-option input[type="radio"]:checked + .service-content {
        border-color: var(--first-color);
        background: rgba(var(--first-color-rgb), 0.1);
    }
    
    .service-option.selected {
        border-color: var(--first-color);
        background: rgba(var(--first-color-rgb), 0.1);
    }
    
    .btn-submit {
        background: var(--first-color);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-submit:hover {
        background: var(--first-color-alt);
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        background: transparent;
        color: var(--text-color);
        border: 2px solid #e5e7eb;
        padding: 1rem 2rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .btn-cancel:hover {
        border-color: var(--first-color);
        color: var(--first-color);
    }
    
    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
    
    .edit-toggle {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .edit-toggle:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .help-text {
        font-size: 0.8rem;
        color: var(--text-color-light);
        margin-top: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .booking-form {
            margin: 1rem;
            padding: 1.5rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .user-info-banner {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<section class="section bd-container" style="margin-top: 4rem;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2.5rem; font-weight: bold; color: var(--title-color); margin-bottom: 0.5rem;">Buat Booking Baru</h1>
        <p style="color: var(--text-color); font-size: 1.1rem;">Isi form di bawah untuk membuat booking cuci sepatu</p>
    </div>

    @if($errors->any())
    <div class="alert alert-error">
        <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
        @csrf
        
        <!-- User Info Banner -->
        <div class="user-info-banner">
            <div class="user-avatar">
                <i class="bx bx-user"></i>
            </div>
            <div class="user-details" style="flex: 1;">
                <h3>Halo, {{ $user->name }}!</h3>
                <p>Form telah diisi otomatis dengan data profil Anda. Anda dapat mengubahnya jika diperlukan.</p>
            </div>
            <button type="button" class="edit-toggle" onclick="toggleEditMode()">
                <i class="bx bx-edit"></i> Edit Data
            </button>
        </div>
        
        <!-- Customer Information -->
        <div class="form-section">
            <h2>Informasi Pelanggan</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="customer_name" class="form-label">Nama Lengkap *</label>
                    <input type="text" id="customer_name" name="customer_name" 
                           value="{{ old('customer_name', $user->name) }}" 
                           class="form-input pre-filled" required readonly>
                    <p class="help-text">Data diambil dari profil Anda</p>
                </div>
                
                <div class="form-group">
                    <label for="customer_phone" class="form-label">Nomor Telepon *</label>
                    <input type="tel" id="customer_phone" name="customer_phone" 
                           value="{{ old('customer_phone', $user->phone ?? '') }}" 
                           class="form-input {{ $user->phone ? 'pre-filled' : '' }}" required 
                           {{ $user->phone ? 'readonly' : '' }}>
                    @if($user->phone)
                        <p class="help-text">Data diambil dari profil Anda</p>
                    @else
                        <p class="help-text">Silakan masukkan nomor telepon Anda</p>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label for="customer_email" class="form-label">Email</label>
                <input type="email" id="customer_email" name="customer_email" 
                       value="{{ old('customer_email', $user->email) }}" 
                       class="form-input pre-filled" readonly>
                <p class="help-text">Data diambil dari profil Anda</p>
            </div>
            
            <div class="form-group">
                <label for="customer_address" class="form-label">Alamat Lengkap *</label>
                <textarea id="customer_address" name="customer_address" rows="3" 
                          class="form-textarea" required 
                          placeholder="Masukkan alamat lengkap untuk pickup/delivery">{{ old('customer_address') }}</textarea>
                <p class="help-text">Alamat untuk pickup dan delivery sepatu</p>
            </div>
        </div>

        <!-- Service Selection -->
        <div class="form-section">
            <h2>Pilih Layanan</h2>
            
            @foreach($services as $service)
            <div class="service-option {{ old('service_id') == $service->id || request('service') == $service->id ? 'selected' : '' }}">
                <label style="display: flex; align-items: flex-start; cursor: pointer;">
                    <input type="radio" name="service_id" value="{{ $service->id }}" 
                           style="margin-right: 1rem; margin-top: 0.25rem;" 
                           {{ old('service_id') == $service->id || request('service') == $service->id ? 'checked' : '' }} required>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <h3 style="font-weight: 600; color: var(--title-color); margin-bottom: 0.5rem;">{{ $service->name }}</h3>
                                <p style="color: var(--text-color); font-size: 0.9rem; margin-bottom: 0.25rem;">{{ $service->description }}</p>
                                <p style="color: var(--text-color-light); font-size: 0.8rem;">Durasi: {{ $service->duration_minutes }} menit</p>
                            </div>
                            <span style="font-size: 1.2rem; font-weight: bold; color: var(--first-color);">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </label>
            </div>
            @endforeach
        </div>

        <!-- Booking Details -->
        <div class="form-section">
            <h2>Detail Booking</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="booking_date" class="form-label">Tanggal Booking *</label>
                    <input type="date" id="booking_date" name="booking_date" 
                           value="{{ old('booking_date', date('Y-m-d', strtotime('+1 day'))) }}" 
                           min="{{ date('Y-m-d') }}" class="form-input" required>
                    <p class="help-text">Minimal booking H+1</p>
                </div>
                
                <div class="form-group">
                    <label for="pickup_time" class="form-label">Waktu Pickup *</label>
                    <input type="time" id="pickup_time" name="pickup_time" 
                           value="{{ old('pickup_time', '09:00') }}" 
                           class="form-input" required>
                    <p class="help-text">Jam operasional: 08:00 - 17:00</p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="delivery_time" class="form-label">Waktu Delivery (Opsional)</label>
                <input type="time" id="delivery_time" name="delivery_time" 
                       value="{{ old('delivery_time') }}" class="form-input">
                <p class="help-text">Kosongkan jika akan diambil sendiri</p>
            </div>
            
            <div class="form-group">
                <label for="payment_method" class="form-label">Metode Pembayaran *</label>
                <select id="payment_method" name="payment_method" class="form-select" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet (GoPay, OVO, DANA)</option>
                    <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                </select>
            </div>
            
            <!-- Bank Transfer Details -->
            <div id="bank-details" style="display: none;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1.5rem; margin: 1rem 0;">
                    <h4 style="color: var(--first-color); margin-bottom: 1rem; font-size: 1.1rem;">
                        <i class="bx bx-bank"></i> Informasi Bank (Opsional)
                    </h4>
                    <p style="color: var(--text-color); font-size: 0.9rem; margin-bottom: 1rem;">
                        Isi informasi bank jika Anda ingin melakukan transfer ke rekening tertentu
                    </p>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="bank_name" class="form-label">Nama Bank</label>
                            <input type="text" id="bank_name" name="bank_name" 
                                   value="{{ old('bank_name') }}" 
                                   class="form-input" 
                                   placeholder="Contoh: BCA, Mandiri, BRI">
                        </div>
                        
                        <div class="form-group">
                            <label for="bank_account_number" class="form-label">Nomor Rekening</label>
                            <input type="text" id="bank_account_number" name="bank_account_number" 
                                   value="{{ old('bank_account_number') }}" 
                                   class="form-input" 
                                   placeholder="Nomor rekening bank">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bank_account_name" class="form-label">Nama Pemilik Rekening</label>
                        <input type="text" id="bank_account_name" name="bank_account_name" 
                               value="{{ old('bank_account_name') }}" 
                               class="form-input" 
                               placeholder="Nama sesuai rekening bank">
                    </div>
                </div>
            </div>
            
            <!-- E-Wallet Details -->
            <div id="ewallet-details" style="display: none;">
                <div style="background: #f0fdf4; border: 1px solid #a7f3d0; border-radius: 0.5rem; padding: 1.5rem; margin: 1rem 0;">
                    <h4 style="color: #10b981; margin-bottom: 1rem; font-size: 1.1rem;">
                        <i class="bx bx-wallet"></i> Informasi E-Wallet (Opsional)
                    </h4>
                    <p style="color: var(--text-color); font-size: 0.9rem; margin-bottom: 1rem;">
                        Isi informasi e-wallet jika Anda ingin melakukan pembayaran via e-wallet tertentu
                    </p>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ewallet_type" class="form-label">Jenis E-Wallet</label>
                            <select id="ewallet_type" name="ewallet_type" class="form-select">
                                <option value="">Pilih E-Wallet</option>
                                <option value="GoPay" {{ old('ewallet_type') == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                                <option value="OVO" {{ old('ewallet_type') == 'OVO' ? 'selected' : '' }}>OVO</option>
                                <option value="DANA" {{ old('ewallet_type') == 'DANA' ? 'selected' : '' }}>DANA</option>
                                <option value="LinkAja" {{ old('ewallet_type') == 'LinkAja' ? 'selected' : '' }}>LinkAja</option>
                                <option value="ShopeePay" {{ old('ewallet_type') == 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ewallet_number" class="form-label">Nomor E-Wallet</label>
                            <input type="text" id="ewallet_number" name="ewallet_number" 
                                   value="{{ old('ewallet_number') }}" 
                                   class="form-input" 
                                   placeholder="Nomor telepon e-wallet">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="ewallet_name" class="form-label">Nama Pemilik E-Wallet</label>
                        <input type="text" id="ewallet_name" name="ewallet_name" 
                               value="{{ old('ewallet_name') }}" 
                               class="form-input" 
                               placeholder="Nama sesuai akun e-wallet">
                    </div>
                </div>
            </div>
            
            <!-- QRIS Details -->
            <div id="qris-details" style="display: none;">
                <div style="background: #fef3c7; border: 1px solid #fbbf24; border-radius: 0.5rem; padding: 1.5rem; margin: 1rem 0;">
                    <h4 style="color: #d97706; margin-bottom: 1rem; font-size: 1.1rem;">
                        <i class="bx bx-qr"></i> Informasi QRIS
                    </h4>
                    <p style="color: var(--text-color); font-size: 0.9rem; margin-bottom: 1rem;">
                        Pembayaran menggunakan QRIS (Quick Response Code Indonesian Standard) - Scan QR code untuk melakukan pembayaran
                    </p>
                    
                    <div style="background: white; border-radius: 0.5rem; padding: 1rem; text-align: center; margin-bottom: 1rem;">
                        <div style="margin: 0 auto; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                            <img src="{{ asset('assets/img/qris.png') }}" alt="QRIS QR Code Preview" style="width: 150px; height: 150px; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 0.5rem;">
                            <p style="color: #6b7280; font-size: 0.8rem; margin: 0;">Preview QR Code QRIS</p>
                        </div>
                    </div>
                    
                    <div style="background: #eff6ff; border: 1px solid #3b82f6; border-radius: 0.375rem; padding: 1rem;">
                        <h5 style="color: #1d4ed8; margin-bottom: 0.5rem; font-size: 0.9rem;">
                            <i class="bx bx-info-circle"></i> Cara Pembayaran QRIS:
                        </h5>
                        <ul style="color: var(--text-color); font-size: 0.8rem; margin: 0; padding-left: 1.5rem;">
                            <li>Buka aplikasi mobile banking atau e-wallet Anda</li>
                            <li>Pilih menu "Scan QR" atau "QRIS"</li>
                            <li>Scan QR code yang akan diberikan setelah booking</li>
                            <li>Konfirmasi pembayaran sesuai nominal yang tertera</li>
                            <li>Simpan bukti pembayaran untuk konfirmasi</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="notes" class="form-label">Catatan Khusus</label>
                <textarea id="notes" name="notes" rows="3" class="form-textarea" 
                          placeholder="Contoh: Sepatu sangat kotor, ada noda membandel, warna khusus, dll.">{{ old('notes') }}</textarea>
                <p class="help-text">Informasi tambahan untuk membantu proses cuci sepatu</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div style="display: flex; gap: 1rem; flex-direction: column;">
            <button type="submit" class="btn-submit">
                <i class="bx bx-check"></i> Buat Booking
            </button>
            <a href="{{ route('booking.index') }}" class="btn-cancel">
                <i class="bx bx-arrow-back"></i> Batal
            </a>
        </div>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Service selection handling
    const serviceOptions = document.querySelectorAll('.service-option');
    serviceOptions.forEach(option => {
        const radio = option.querySelector('input[type="radio"]');
        
        option.addEventListener('click', function() {
            serviceOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            radio.checked = true;
        });
    });
    
    // Payment method handling
    const paymentMethod = document.getElementById('payment_method');
    const bankDetails = document.getElementById('bank-details');
    const ewalletDetails = document.getElementById('ewallet-details');
    const qrisDetails = document.getElementById('qris-details');
    
    function togglePaymentDetails() {
        const selectedMethod = paymentMethod.value;
        
        // Hide all payment details first
        bankDetails.style.display = 'none';
        ewalletDetails.style.display = 'none';
        qrisDetails.style.display = 'none';
        
        // Show relevant details based on selection
        if (selectedMethod === 'transfer') {
            bankDetails.style.display = 'block';
        } else if (selectedMethod === 'e_wallet') {
            ewalletDetails.style.display = 'block';
        } else if (selectedMethod === 'qris') {
            qrisDetails.style.display = 'block';
        }
    }
    
    // Initial check for payment method
    togglePaymentDetails();
    
    // Listen for payment method changes
    paymentMethod.addEventListener('change', togglePaymentDetails);
    
    // Time validation
    const pickupTime = document.getElementById('pickup_time');
    const deliveryTime = document.getElementById('delivery_time');
    
    pickupTime.addEventListener('change', function() {
        const time = this.value;
        if (time < '08:00' || time > '17:00') {
            alert('Jam pickup harus antara 08:00 - 17:00');
            this.value = '09:00';
        }
    });
    
    deliveryTime.addEventListener('change', function() {
        const time = this.value;
        if (time && (time < '08:00' || time > '17:00')) {
            alert('Jam delivery harus antara 08:00 - 17:00');
            this.value = '';
        }
    });
});

function toggleEditMode() {
    const readonlyFields = document.querySelectorAll('.form-input[readonly], .form-textarea[readonly]');
    const button = document.querySelector('.edit-toggle');
    
    readonlyFields.forEach(field => {
        if (field.hasAttribute('readonly')) {
            field.removeAttribute('readonly');
            field.classList.remove('pre-filled');
            button.innerHTML = '<i class="bx bx-lock"></i> Kunci Data';
        } else {
            field.setAttribute('readonly', true);
            field.classList.add('pre-filled');
            button.innerHTML = '<i class="bx bx-edit"></i> Edit Data';
        }
    });
}
</script>
@endsection