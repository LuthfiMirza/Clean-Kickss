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
    
    @media (max-width: 768px) {
        .booking-form {
            margin: 1rem;
            padding: 1.5rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
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
            
            <!-- Customer Information -->
            <div class="form-section">
                <h2>Informasi Pelanggan</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="customer_name" class="form-label">Nama Lengkap *</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" 
                               class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="customer_phone" class="form-label">Nomor Telepon *</label>
                        <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" 
                               class="form-input" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="customer_email" class="form-label">Email</label>
                    <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" 
                           class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="customer_address" class="form-label">Alamat Lengkap *</label>
                    <textarea id="customer_address" name="customer_address" rows="3" 
                              class="form-textarea" required>{{ old('customer_address') }}</textarea>
                </div>
            </div>

            <!-- Service Selection -->
            <div class="form-section">
                <h2>Pilih Layanan</h2>
                
                @foreach($services as $service)
                <div class="service-option">
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
                        <input type="date" id="booking_date" name="booking_date" value="{{ old('booking_date') }}" 
                               min="{{ date('Y-m-d') }}" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="pickup_time" class="form-label">Waktu Pickup *</label>
                        <input type="time" id="pickup_time" name="pickup_time" value="{{ old('pickup_time') }}" 
                               class="form-input" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="delivery_time" class="form-label">Waktu Delivery (Opsional)</label>
                    <input type="time" id="delivery_time" name="delivery_time" value="{{ old('delivery_time') }}" 
                           class="form-input">
                    <p style="font-size: 0.8rem; color: var(--text-color-light); margin-top: 0.25rem;">Kosongkan jika akan diambil sendiri</p>
                </div>
                
                <div class="form-group">
                    <label for="payment_method" class="form-label">Metode Pembayaran *</label>
                    <select id="payment_method" name="payment_method" class="form-select" required>
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="notes" class="form-label">Catatan Khusus</label>
                    <textarea id="notes" name="notes" rows="3" class="form-textarea" 
                              placeholder="Contoh: Sepatu sangat kotor, ada noda membandel, dll.">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div style="display: flex; gap: 1rem; flex-direction: column;">
                <button type="submit" class="btn-submit">
                    Buat Booking
                </button>
                <a href="{{ route('booking.index') }}" class="btn-cancel">
                    Batal
                </a>
            </div>
        </form>
</section>
@endsection