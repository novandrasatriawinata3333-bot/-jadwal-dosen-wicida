<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['jadwal', 'dosen'])
            ->where('user_id', Auth::id());

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')
            ->paginate(15);

        return view('booking.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('booking.show', compact('booking'));
    }

    public function approve(Booking $booking)
    {
        $this->authorize('update', $booking);
        
        $booking->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Booking berhasil disetujui!');
    }

    public function reject(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'alasan_reject' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'rejected',
            'alasan_reject' => $validated['alasan_reject'],
        ]);

        return redirect()->back()->with('success', 'Booking berhasil ditolak!');
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);
        
        $booking->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Booking berhasil dibatalkan!');
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->delete();

        return redirect()->route('booking.index')->with('success', 'Booking berhasil dihapus!');
    }
}
