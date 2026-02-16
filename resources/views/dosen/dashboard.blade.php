<x-app-layout>
    @section('title', 'Dashboard')
    
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold">📊 Dashboard</h1>
            <p class="text-lg opacity-70 mt-2">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Jadwal -->
            <div class="stats shadow-lg">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="stat-title">Total Jadwal</div>
                    <div class="stat-value text-primary">{{ $stats['total_jadwal'] }}</div>
                    <div class="stat-desc">Jadwal aktif minggu ini</div>
                </div>
            </div>

            <!-- Pending Booking -->
            <div class="stats shadow-lg">
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-title">Booking Pending</div>
                    <div class="stat-value text-warning">{{ $stats['pending_booking'] }}</div>
                    <div class="stat-desc">Menunggu persetujuan</div>
                </div>
            </div>

            <!-- Approved Booking -->
            <div class="stats shadow-lg">
                <div class="stat">
                    <div class="stat-figure text-success">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-title">Booking Disetujui</div>
                    <div class="stat-value text-success">{{ $stats['approved_booking'] }}</div>
                    <div class="stat-desc">Konsultasi terjadwal</div>
                </div>
            </div>

            <!-- Status -->
            <div class="stats shadow-lg">
                <div class="stat">
                    <div class="stat-title">Status Saat Ini</div>
                    <div class="stat-value text-base
                        @if($stats['status'] === 'Ada') text-success
                        @elseif($stats['status'] === 'Mengajar') text-warning
                        @elseif($stats['status'] === 'Konsultasi') text-info
                        @else text-error
                        @endif">
                        {{ $stats['status'] }}
                    </div>
                    <div class="stat-desc">Real-time status</div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Quick Actions (2 cols) -->
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title text-2xl mb-4">⚡ Quick Actions</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-lg">
                                <span class="text-2xl">➕</span>
                                <span>Tambah Jadwal</span>
                            </a>
                            <a href="{{ route('booking.index') }}" class="btn btn-warning btn-lg">
                                <span class="text-2xl">📋</span>
                                <span>Lihat Booking</span>
                            </a>
                            <a href="{{ route('jadwal.index') }}" class="btn btn-info btn-lg">
                                <span class="text-2xl">📅</span>
                                <span>Kelola Jadwal</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="btn btn-accent btn-lg">
                                <span class="text-2xl">👤</span>
                                <span>Edit Profile</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Update (1 col) -->
            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-2">🔄 Update Status</h2>
                        <p class="text-sm opacity-70 mb-4">Status: <strong id="current-status">{{ $stats['status'] }}</strong></p>
                        
                        <form id="statusUpdateForm">
                            @csrf
                            <div class="space-y-2">
                                <div class="form-control">
                                    <label class="label cursor-pointer justify-start gap-3">
                                        <input type="radio" name="status" value="Ada" class="radio radio-success" 
                                            {{ $stats['status'] === 'Ada' ? 'checked' : '' }}>
                                        <span class="label-text">🟢 Ada</span>
                                    </label>
                                </div>
                                <div class="form-control">
                                    <label class="label cursor-pointer justify-start gap-3">
                                        <input type="radio" name="status" value="Mengajar" class="radio radio-warning"
                                            {{ $stats['status'] === 'Mengajar' ? 'checked' : '' }}>
                                        <span class="label-text">🟡 Mengajar</span>
                                    </label>
                                </div>
                                <div class="form-control">
                                    <label class="label cursor-pointer justify-start gap-3">
                                        <input type="radio" name="status" value="Konsultasi" class="radio radio-info"
                                            {{ $stats['status'] === 'Konsultasi' ? 'checked' : '' }}>
                                        <span class="label-text">🔵 Konsultasi</span>
                                    </label>
                                </div>
                                <div class="form-control">
                                    <label class="label cursor-pointer justify-start gap-3">
                                        <input type="radio" name="status" value="Tidak Ada" class="radio radio-error"
                                            {{ $stats['status'] === 'Tidak Ada' ? 'checked' : '' }}>
                                        <span class="label-text">🔴 Tidak Ada</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                        <div id="status-message" class="mt-4 hidden"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Minggu Ini -->
        @if($jadwals->count() > 0)
        <div class="card bg-base-100 shadow-xl mb-8">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">📅 Jadwal Minggu Ini</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
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
                                <td><strong>{{ $jadwal->hari }}</strong></td>
                                <td class="whitespace-nowrap">
                                    {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($jadwal->kegiatan === 'Mengajar') badge-primary
                                        @elseif($jadwal->kegiatan === 'Konsultasi') badge-info
                                        @elseif($jadwal->kegiatan === 'Rapat') badge-warning
                                        @else badge-ghost
                                        @endif">
                                        {{ $jadwal->kegiatan }}
                                    </span>
                                </td>
                                <td>{{ $jadwal->ruangan ?? '-' }}</td>
                                <td>
                                    <div class="tooltip" data-tip="{{ $jadwal->keterangan ?? 'Tidak ada keterangan' }}">
                                        {{ Str::limit($jadwal->keterangan, 20) ?: '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="join">
                                        <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="btn btn-xs btn-ghost join-item">
                                            ✏️
                                        </a>
                                        <form method="POST" action="{{ route('jadwal.destroy', $jadwal->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-ghost join-item" 
                                                    onclick="return confirm('Yakin hapus jadwal ini?')">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('jadwal.index') }}" class="btn btn-primary">
                        Lihat Semua Jadwal →
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Bookings -->
        @if($recentBookings->count() > 0)
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">📝 Booking Terbaru (Pending)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($recentBookings as $booking)
                    <div class="card bg-base-200">
                        <div class="card-body p-4">
                            <h3 class="font-bold">{{ $booking->nama_mahasiswa }}</h3>
                            <p class="text-sm opacity-70">{{ $booking->email_mahasiswa }}</p>
                            <p class="text-sm">📅 {{ $booking->tanggal_booking->format('d M Y') }}</p>
                            <p class="text-sm">⏰ {{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }}</p>
                            <p class="text-sm mt-2">{{ Str::limit($booking->keperluan, 60) }}</p>
                            <div class="card-actions justify-end mt-2">
                                <a href="{{ route('booking.index') }}" class="btn btn-xs btn-primary">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('booking.index') }}" class="btn btn-warning">
                        Lihat Semua Booking →
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        // Auto-update status via AJAX
        document.querySelectorAll('input[name="status"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const messageDiv = document.getElementById('status-message');
                const currentStatus = document.getElementById('current-status');
                
                fetch('{{ route("status.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: this.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        currentStatus.textContent = this.value;
                        messageDiv.className = 'mt-4 alert alert-success';
                        messageDiv.textContent = '✅ ' + data.message;
                        messageDiv.classList.remove('hidden');
                        
                        setTimeout(() => {
                            messageDiv.classList.add('hidden');
                        }, 3000);
                    }
                })
                .catch(error => {
                    messageDiv.className = 'mt-4 alert alert-error';
                    messageDiv.textContent = '❌ Gagal update status';
                    messageDiv.classList.remove('hidden');
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
