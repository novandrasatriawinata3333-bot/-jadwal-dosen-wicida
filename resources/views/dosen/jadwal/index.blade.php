<x-app-layout>
    @section('title', 'Jadwal Saya')
    
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold">📅 Jadwal Saya</h1>
            <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
                ➕ Tambah Jadwal
            </a>
        </div>

        @if($jadwals->count() > 0)
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Kegiatan</th>
                            <th>Ruangan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $jadwal)
                            <tr>
                                <td>{{ $jadwal->hari }}</td>
                                <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                <td><span class="badge">{{ $jadwal->kegiatan }}</span></td>
                                <td>{{ $jadwal->ruangan ?? '-' }}</td>
                                <td>{{ Str::limit($jadwal->keterangan ?? '-', 30) }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('jadwal.destroy', $jadwal) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $jadwals->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <p>Belum ada jadwal. Klik "Tambah Jadwal" untuk membuat jadwal baru.</p>
            </div>
        @endif
    </div>
</x-app-layout>
