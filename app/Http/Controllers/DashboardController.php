<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $bookings = Booking::with(['jadwal', 'dosen'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'pending' => Booking::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Booking::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected' => Booking::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        return view('dashboard', compact('bookings', 'stats'));
    }

    public function getStats()
    {
        $user = Auth::user();
        
        return response()->json([
            'pending' => Booking::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Booking::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected' => Booking::where('user_id', $user->id)->where('status', 'rejected')->count(),
            'total_jadwal' => $user->jadwals()->count(),
        ]);
    }
}
