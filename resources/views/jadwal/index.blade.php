<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Jadwal</h1>
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">+ Tambah Jadwal</a>
    </div>

    <div class="stats shadow mb-6">
        <div class="stat">
            <div class="stat-title">Total Jadwal</div>
            <div class="stat-value">{{ $jadwals->total() }}</div>
        </div>
    </div>

    @if($jadwals->count() > 0)
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Waktu</th>
                                <th>Ruangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwals as $jadwal)
                                <tr>
                                    <td>{{ $jadwal->hari }}</td>
                                    <td>{{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</td>
                                    <td>{{ $jadwal->ruangan }}</td>
                                    <td>
                                        <span class="badge badge-{{ $jadwal->is_active ? 'success' : 'error' }}">
                                            {{ $jadwal->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="btn btn-sm btn-ghost">Edit</a>
                                        <form method="POST" action="{{ route('jadwal.destroy', $jadwal->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-error" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $jadwals->links() }}
            </div>
        </div>
    @else
        <div class="alert">Belum ada jadwal. <a href="{{ route('jadwal.create') }}" class="link">Tambah jadwal baru</a></div>
    @endif
</x-app-layout>
