<div class="space-y-6">
    <!-- Booking Information -->
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Pelanggan:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $booking->customer->name }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Layanan:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $booking->service->name }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Total:</span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Metode:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $booking->payment_method_label }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Status Pembayaran:</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                    {{ $booking->payment_status_label }}
                </span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Tanggal Upload:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $booking->updated_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Proof Image -->
    <div class="text-center">
        <div class="inline-block bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
            @if($imageUrl)
                <img 
                    src="{{ $imageUrl }}" 
                    alt="Bukti Pembayaran Booking #{{ $booking->id }}"
                    class="max-w-full max-h-96 object-contain"
                    style="max-height: 500px;"
                />
            @else
                <div class="flex items-center justify-center h-48 bg-gray-100 dark:bg-gray-800">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada bukti pembayaran</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Image Actions -->
    @if($imageUrl)
    <div class="flex justify-center space-x-3">
        <a 
            href="{{ $imageUrl }}" 
            target="_blank"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            Buka di Tab Baru
        </a>
        
        <a 
            href="{{ $imageUrl }}" 
            download="bukti-pembayaran-{{ $booking->id }}.jpg"
            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-200"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download
        </a>
    </div>
    @endif

    <!-- Payment Status Actions -->
    @if($booking->payment_status !== 'paid' && $imageUrl)
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                    Verifikasi Pembayaran
                </h3>
                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                    <p>Bukti pembayaran telah diupload. Silakan verifikasi dan update status pembayaran jika sudah sesuai.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>