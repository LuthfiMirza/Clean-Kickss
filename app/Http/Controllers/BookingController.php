<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('booking.create', compact('services'));
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
            'payment_method' => 'required|in:cash,transfer,e_wallet,credit_card'
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
}