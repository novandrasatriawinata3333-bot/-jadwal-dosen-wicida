<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Display homepage with list of all lecturers
     */
    public function index()
    {
        $dosens = User::dosen()
            ->with(['status', 'jadwals'])
            ->orderBy('role', 'desc') // Kepala lab first
            ->orderBy('name')
            ->get();

        return view('home', compact('dosens'));
    }

    /**
     * Show lecturer detail with schedule and booking form
     */
    public function show($id)
    {
        $dosen = User::dosen()
            ->with([
                'jadwals' => function($query) {
                    $query->orderByRaw("
                        FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')
                    ")->orderBy('jam_mulai');
                },
                'status'
            ])
            ->findOrFail($id);

        // Group jadwals by hari
        $jadwalsByDay = $dosen->jadwals->groupBy('hari');

        return view('jadwal.detail', compact('dosen', 'jadwalsByDay'));
    }

    /**
     * Store booking consultation request
     */
    public function storeBooking(Request $request, $id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'nama_mahasiswa' => 'required|string|max:255',
            'email_mahasiswa' => 'required|email|max:255',
            'nim_mahasiswa' => 'nullable|string|max:20',
            'tanggal_booking' => 'required|date|after:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'keperluan' => 'required|string|min:10',
        ], [
            'nama_mahasiswa.required' => 'Nama lengkap wajib diisi',
            'email_mahasiswa.required' => 'Email wajib diisi',
            'email_mahasiswa.email' => 'Format email tidak valid',
            'tanggal_booking.required' => 'Tanggal booking wajib diisi',
            'tanggal_booking.after' => 'Tanggal booking minimal besok',
            'jam_mulai.required' => 'Jam mulai wajib diisi',
            'jam_selesai.required' => 'Jam selesai wajib diisi',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'keperluan.required' => 'Keperluan konsultasi wajib diisi',
            'keperluan.min' => 'Keperluan minimal 10 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify dosen exists
        $dosen = User::dosen()->findOrFail($id);

        // Check for duplicate booking
        $duplicate = Booking::where('user_id', $id)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($duplicate) {
            return redirect()->back()
                ->with('error', 'Jadwal yang Anda pilih sudah dibooking. Silakan pilih waktu lain.')
                ->withInput();
        }

        // Create booking
        Booking::create([
            'user_id' => $id,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'email_mahasiswa' => $request->email_mahasiswa,
            'nim_mahasiswa' => $request->nim_mahasiswa,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keperluan' => $request->keperluan,
            'status' => 'pending',
        ]);

        return redirect()->back()
            ->with('success', '✅ Booking berhasil diajukan! Silakan tunggu konfirmasi dari ' . $dosen->name);
    }
}
