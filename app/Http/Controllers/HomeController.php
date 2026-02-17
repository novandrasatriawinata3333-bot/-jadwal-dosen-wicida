<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $dosens = User::with(['status', 'jadwals' => function($query) {
            $query->where('is_active', true);
        }])->get();

        return view('home', compact('dosens'));
    }

    public function show($id)
    {
        $dosen = User::with(['jadwals' => function($query) {
            $query->where('is_active', true)->orderBy('hari');
        }, 'status'])->findOrFail($id);

        return view('dosen.show', compact('dosen'));
    }

    public function storeBooking(Request $request, $dosenId)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'nama_mahasiswa' => 'required|string|max:100',
            'nim' => 'required|string|max:20',
            'email_mahasiswa' => 'required|email|max:100',
            'no_hp' => 'required|string|max:20',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'keperluan' => 'required|string|max:500',
        ]);

        // Pastikan jadwal milik dosen yang dipilih
        $jadwal = Jadwal::findOrFail($validated['jadwal_id']);
        if ($jadwal->user_id != $dosenId) {
            return back()->withErrors(['jadwal_id' => 'Jadwal tidak valid']);
        }

        // Cek jadwal sudah dipesan belum
        $existing = Booking::where('jadwal_id', $validated['jadwal_id'])
            ->where('tanggal_booking', $validated['tanggal_booking'])
            ->where('status', 'approved')
            ->exists();

        if ($existing) {
            return back()->withErrors(['tanggal_booking' => 'Jadwal pada tanggal ini sudah dipesan']);
        }

        $validated['user_id'] = $dosenId;
        $validated['status'] = 'pending';

        Booking::create($validated);

        return redirect()->back()->with('success', '✅ Booking berhasil diajukan! Silakan tunggu konfirmasi dosen.');
    }
}
