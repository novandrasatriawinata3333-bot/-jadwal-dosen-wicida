<x-app-layout>
    @section('title', 'Kelola Jadwal')
    
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold">📅 Kelola Jadwal</h1>
                <p class="text-sm opacity-70 mt-2">Atur jadwal mengajar dan konsultasi Anda</p>
            </div>
            <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-lg gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jadwal
            </a>
        </div>

        <!-- Stats -->
        <div class="stats stats-vertical lg:stats-horizontal shadow mb-8 w-full">
            <div class="stat">
                <div class="stat-title">Total Jadwal</div>
                <div class="stat-value">{{ $jadwals->total() }}</div>
                <div class="stat-desc">Jadwal aktif</div>
            </div>
            <div class="stat">
                <div class="stat-title">Minggu Ini</div>
                <div class="stat-value text-primary">{{ $jadwals->where('hari', '>=', 'Senin')->count() }}</div>
                <div class="stat-desc">Senin - Jumat</div>
            </div>
        </div>

        @if($jadwals->count() > 0)
            <!-- Jadwal Table -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th class="w-16">No</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Kegiatan</th>
                                    <th>Ruangan</th>
                                    <th>Keterangan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwals as $index => $jadwal)
                                <tr class="hover">
                                    <td>{{ $jadwals->firstItem() + $index }}</td>
                                    <td>
                                        <div class="badge badge-outline badge-lg">
                                            {{ $jadwal->hari }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap font-mono">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-lg
                                            @if($jadwal->kegiatan === 'Mengajar') badge-primary
                                            @elseif($jadwal->kegiatan === 'Konsultasi') badge-info
                                            @elseif($jadwal->kegiatan === 'Rapat') badge-warning
                                            @else badge-ghost
                                            @endif">
                                            @if($jadwal->kegiatan === 'Mengajar') 📚
                                            @elseif($jadwal->kegiatan === 'Konsultasi') 💬
                                            @elseif($jadwal->kegiatan === 'Rapat') 👥
                                            @else 📌
                                            @endif
                                            {{ $jadwal->kegiatan }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            @if($jadwal->ruangan)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $jadwal->ruangan }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($jadwal->keterangan)
                                            <div class="tooltip tooltip-left" data-tip="{{ $jadwal->keterangan }}">
                                                <span class="text-sm">{{ Str::limit($jadwal->keterangan, 30) }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex justify-center gap-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('jadwal.edit', $jadwal->id) }}" 
                                               class="btn btn-ghost btn-sm tooltip" 
                                               data-tip="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('jadwal.destroy', $jadwal->id) }}" 
                                                  onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-ghost btn-sm text-error tooltip" 
                                                        data-tip="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $jadwals->links() }}
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center py-20">
                    <div class="text-8xl mb-6">📅</div>
                    <h3 class="text-3xl font-bold mb-4">Belum Ada Jadwal</h3>
                    <p class="text-lg opacity-70 mb-6">Mulai tambahkan jadwal mengajar atau konsultasi Anda</p>
                    <div>
                        <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Jadwal Pertama
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
