<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        // GANTI get() dengan paginate()
        $jadwals = Jadwal::where('user_id', Auth::id())
            ->orderBy('hari')
            ->orderBy('waktu_mulai')
            ->paginate(10); // ← FIX: gunakan paginate

        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'ruangan' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();

        Jadwal::create($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Jadwal $jadwal)
    {
        $this->authorize('update', $jadwal);
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $this->authorize('update', $jadwal);

        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'ruangan' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $jadwal->update($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $this->authorize('delete', $jadwal);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }

    public function getByDay(Request $request)
    {
        $hari = $request->query('hari');
        $userId = $request->query('user_id');

        $jadwals = Jadwal::where('user_id', $userId)
            ->where('hari', $hari)
            ->where('is_active', true)
            ->get();

        return response()->json($jadwals);
    }
}
