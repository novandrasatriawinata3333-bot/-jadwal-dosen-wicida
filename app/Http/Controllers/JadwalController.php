<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Auth::user()->jadwals()
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('jam_mulai')
            ->paginate(15);

        return view('dosen.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('dosen.jadwal.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:100',
            'kegiatan' => 'required|in:Mengajar,Konsultasi,Rapat,Lainnya',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();
        Jadwal::create($validated);

        return redirect()->route('jadwal.index')
            ->with('success', '✅ Jadwal berhasil ditambahkan!');
    }

    public function edit(Jadwal $jadwal)
    {
        $this->authorize('update', $jadwal);
        return view('dosen.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $this->authorize('update', $jadwal);

        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:100',
            'kegiatan' => 'required|in:Mengajar,Konsultasi,Rapat,Lainnya',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $jadwal->update($validated);

        return redirect()->route('jadwal.index')
            ->with('success', '✅ Jadwal berhasil diperbarui!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $this->authorize('delete', $jadwal);
        $jadwal->delete();

        return redirect()->route('jadwal.index')
            ->with('success', '🗑️ Jadwal berhasil dihapus!');
    }
}
