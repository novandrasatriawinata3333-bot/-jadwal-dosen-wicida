<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->bookings();

        $statusFilter = $request->query('status', 'all');
        
        if ($statusFilter !== 'all' && in_array($statusFilter, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $statusFilter);
        }

        $bookings = $query->latest('tanggal_booking')->paginate(12);

        $statusCounts = [
            'all' => Auth::user()->bookings()->count(),
            'pending' => Auth::user()->bookings()->where('status', 'pending')->count(),
            'approved' => Auth::user()->bookings()->where('status', 'approved')->count(),
            'rejected' => Auth::user()->bookings()->where('status', 'rejected')->count(),
        ];

        return view('dosen.booking.index', compact('bookings', 'statusFilter', 'statusCounts'));
    }

    public function approve(Booking $booking)
    {
        $this->authorize('update', $booking);

        $booking->update(['status' => 'approved']);

        return redirect()->back()
            ->with('success', '✅ Booking telah disetujui!');
    }

    public function reject(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $request->validate([
            'alasan_reject' => 'required|string|min:10',
        ]);

        $booking->update([
            'status' => 'rejected',
            'alasan_reject' => $request->alasan_reject,
        ]);

        return redirect()->back()
            ->with('success', '❌ Booking telah ditolak!');
    }
}
