<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's bookings based on phone number or email with more flexible matching
        $bookings = Booking::whereHas('customer', function($query) use ($user) {
            $query->where(function($q) use ($user) {
                // Match by email if both exist
                if ($user->email) {
                    $q->where('email', $user->email);
                }
                
                // Match by phone if both exist
                if ($user->phone) {
                    $q->orWhere('phone', $user->phone);
                }
                
                // Also try to match by similar phone numbers (remove spaces, dashes, etc.)
                if ($user->phone) {
                    $cleanUserPhone = preg_replace('/[^0-9]/', '', $user->phone);
                    if (strlen($cleanUserPhone) > 6) {
                        $q->orWhereRaw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', '') LIKE ?", ['%' . substr($cleanUserPhone, -8) . '%']);
                    }
                }
            });
        })->with(['service', 'customer'])
          ->orderBy('created_at', 'desc')
          ->get();

        // If no bookings found and user has phone, try to find by partial phone match
        if ($bookings->isEmpty() && $user->phone) {
            $cleanUserPhone = preg_replace('/[^0-9]/', '', $user->phone);
            if (strlen($cleanUserPhone) >= 8) {
                $bookings = Booking::whereHas('customer', function($query) use ($cleanUserPhone) {
                    $query->whereRaw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', '') LIKE ?", ['%' . substr($cleanUserPhone, -8) . '%']);
                })->with(['service', 'customer'])
                  ->orderBy('created_at', 'desc')
                  ->get();
            }
        }

        // Calculate statistics
        $totalBookings = $bookings->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $completedBookings = $bookings->where('status', 'delivered')->count();
        $activeBookings = $bookings->whereNotIn('status', ['delivered', 'cancelled'])->count();

        return view('dashboard.index', compact(
            'user', 
            'bookings', 
            'totalBookings', 
            'pendingBookings', 
            'completedBookings', 
            'activeBookings'
        ));
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        return view('dashboard.profile');
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Show user's bookings
     */
    public function bookings()
    {
        $user = Auth::user();
        
        // Use the same flexible matching logic as in index method
        $bookings = Booking::whereHas('customer', function($query) use ($user) {
            $query->where(function($q) use ($user) {
                // Match by email if both exist
                if ($user->email) {
                    $q->where('email', $user->email);
                }
                
                // Match by phone if both exist
                if ($user->phone) {
                    $q->orWhere('phone', $user->phone);
                }
                
                // Also try to match by similar phone numbers (remove spaces, dashes, etc.)
                if ($user->phone) {
                    $cleanUserPhone = preg_replace('/[^0-9]/', '', $user->phone);
                    if (strlen($cleanUserPhone) > 6) {
                        $q->orWhereRaw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', '') LIKE ?", ['%' . substr($cleanUserPhone, -8) . '%']);
                    }
                }
            });
        })->with(['service', 'customer'])
          ->orderBy('created_at', 'desc')
          ->paginate(10);

        // If no bookings found and user has phone, try to find by partial phone match
        if ($bookings->isEmpty() && $user->phone) {
            $cleanUserPhone = preg_replace('/[^0-9]/', '', $user->phone);
            if (strlen($cleanUserPhone) >= 8) {
                $bookings = Booking::whereHas('customer', function($query) use ($cleanUserPhone) {
                    $query->whereRaw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', '') LIKE ?", ['%' . substr($cleanUserPhone, -8) . '%']);
                })->with(['service', 'customer'])
                  ->orderBy('created_at', 'desc')
                  ->paginate(10);
            }
        }

        return view('dashboard.bookings', compact('bookings'));
    }

    /**
     * Search for bookings by phone number to help users connect their account
     */
    public function searchBookings(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'phone' => 'required|string|min:8'
        ]);

        $searchPhone = $request->phone;
        $cleanSearchPhone = preg_replace('/[^0-9]/', '', $searchPhone);
        
        // Search for bookings with this phone number
        $foundBookings = Booking::whereHas('customer', function($query) use ($searchPhone, $cleanSearchPhone) {
            $query->where('phone', $searchPhone)
                  ->orWhere('phone', 'LIKE', '%' . $searchPhone . '%')
                  ->orWhereRaw("REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', '') LIKE ?", ['%' . $cleanSearchPhone . '%']);
        })->with(['service', 'customer'])
          ->orderBy('created_at', 'desc')
          ->get();

        return response()->json([
            'success' => true,
            'bookings' => $foundBookings,
            'message' => $foundBookings->count() > 0 
                ? 'Ditemukan ' . $foundBookings->count() . ' booking dengan nomor telepon tersebut.'
                : 'Tidak ada booking ditemukan dengan nomor telepon tersebut.'
        ]);
    }

    /**
     * Update user phone to match existing bookings
     */
    public function updatePhoneForBookings(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'phone' => 'required|string|min:8'
        ]);

        // Update user's phone number
        $user->update(['phone' => $request->phone]);

        return redirect()->route('dashboard')->with('success', 'Nomor telepon berhasil diperbarui! Sekarang Anda dapat melihat booking yang terkait dengan nomor tersebut.');
    }
}