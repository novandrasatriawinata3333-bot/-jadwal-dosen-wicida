<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistics
        $stats = [
            'total_jadwal' => $user->jadwals()->count(),
            'pending_booking' => $user->bookings()->where('status', 'pending')->count(),
            'approved_booking' => $user->bookings()->where('status', 'approved')->count(),
            'status' => $user->status ? $user->status->status : 'Tidak Ada',
        ];

        // Recent jadwals
        $jadwals = $user->jadwals()
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('jam_mulai')
            ->limit(10)
            ->get();

        // Recent bookings
        $recentBookings = $user->bookings()
            ->where('tanggal_booking', '>=', today())
            ->where('status', 'pending')
            ->orderBy('tanggal_booking')
            ->limit(5)
            ->get();

        return view('dosen.dashboard', compact('stats', 'jadwals', 'recentBookings'));
    }
}
