<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        return view('booking.index', compact('services'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $user = auth()->user();
        return view('booking.create', compact('services', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'required|string',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|date_format:H:i',
            'delivery_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cash,transfer,e_wallet,credit_card',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'ewallet_type' => 'nullable|string|max:255',
            'ewallet_number' => 'nullable|string|max:255',
            'ewallet_name' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        
        try {
            // Create or find customer
            $customer = Customer::firstOrCreate(
                ['phone' => $request->customer_phone],
                [
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'address' => $request->customer_address,
                ]
            );

            // Get service details
            $service = Service::findOrFail($request->service_id);

            // Create booking
            $pickupDateTime = $request->booking_date . ' ' . $request->pickup_time;
            $deliveryDateTime = $request->delivery_time ? $request->booking_date . ' ' . $request->delivery_time : null;
            
            $booking = Booking::create([
                'user_id' => auth()->id(), // Link to authenticated user
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'booking_date' => $request->booking_date,
                'pickup_time' => $pickupDateTime,
                'delivery_time' => $deliveryDateTime,
                'status' => 'pending',
                'notes' => $request->notes,
                'total_price' => $service->price,
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'ewallet_type' => $request->ewallet_type,
                'ewallet_number' => $request->ewallet_number,
                'ewallet_name' => $request->ewallet_name,
            ]);

            DB::commit();

            return redirect()->route('booking.success', $booking->id)
                ->with('success', 'Booking berhasil dibuat! Kami akan menghubungi Anda untuk konfirmasi.');

        } catch (\Exception $e) {
            DB::rollback();
            
            // Log the error for debugging
            \Log::error('Booking creation failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat membuat booking. Error: ' . $e->getMessage()]);
        }
    }

    public function success($id)
    {
        $booking = Booking::with(['customer', 'service'])->findOrFail($id);
        return view('booking.success', compact('booking'));
    }

    public function track()
    {
        return view('booking.track');
    }

    public function trackResult(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'booking_id' => 'nullable|string'
        ]);

        $query = Booking::with(['customer', 'service']);

        if ($request->booking_id) {
            $query->where('id', $request->booking_id);
        }

        $bookings = $query->whereHas('customer', function($q) use ($request) {
            $q->where('phone', $request->phone);
        })->orderBy('created_at', 'desc')->get();

        return view('booking.track-result', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['customer', 'service'])->findOrFail($id);
        return view('booking.show', compact('booking'));
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        $booking = Booking::with(['customer', 'user'])->findOrFail($id);
        
        // Check if user owns this booking
        $user = auth()->user();
        $canUpload = false;
        
        // Check ownership in order of preference:
        // 1. User ID matches booking user_id (most reliable)
        // 2. User email matches customer email (if both exist)
        // 3. User phone matches customer phone (if user has phone field)
        // 4. User is admin (if admin field exists)
        
        if ($booking->user_id && $booking->user_id === $user->id) {
            $canUpload = true;
        } elseif ($booking->customer->email && $user->email && $booking->customer->email === $user->email) {
            $canUpload = true;
        } elseif (isset($user->phone) && $user->phone && $booking->customer->phone === $user->phone) {
            $canUpload = true;
        } elseif (isset($user->is_admin) && $user->is_admin) {
            $canUpload = true;
        }
        
        if (!$canUpload) {
            return back()->withErrors(['error' => 'Anda tidak memiliki akses untuk mengupload bukti pembayaran booking ini.']);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'payment_proof.required' => 'File bukti pembayaran harus diupload.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.mimes' => 'File harus berformat: jpeg, png, jpg, atau gif.',
            'payment_proof.max' => 'Ukuran file maksimal 2MB.'
        ]);

        try {
            // Delete old payment proof if exists
            if ($booking->payment_proof) {
                Storage::disk('public')->delete($booking->payment_proof);
            }

            // Store new payment proof
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');
            
            // Update booking
            $booking->update([
                'payment_proof' => $path,
                'payment_status' => 'paid'
            ]);

            return back()->with('success', 'Bukti pembayaran berhasil diupload! Status pembayaran telah diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengupload bukti pembayaran: ' . $e->getMessage()]);
        }
    }
}