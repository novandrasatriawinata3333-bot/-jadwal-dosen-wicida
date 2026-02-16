<x-app-layout>
    @section('title', 'Kelola Booking')
    
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold">📝 Kelola Booking Konsultasi</h1>
            <p class="text-sm opacity-70 mt-2">Kelola permintaan konsultasi dari mahasiswa</p>
        </div>

        <!-- Stats -->
        <div class="stats stats-vertical lg:stats-horizontal shadow mb-8 w-full">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Total Booking</div>
                <div class="stat-value">{{ $statusCounts['all'] }}</div>
                <div class="stat-desc">Semua permintaan</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Pending</div>
                <div class="stat-value text-warning">{{ $statusCounts['pending'] }}</div>
                <div class="stat-desc">Menunggu</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Disetujui</div>
                <div class="stat-value text-success">{{ $statusCounts['approved'] }}</div>
                <div class="stat-desc">Terjadwal</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Ditolak</div>
                <div class="stat-value text-error">{{ $statusCounts['rejected'] }}</div>
                <div class="stat-desc">Dibatalkan</div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="tabs tabs-boxed bg-base-100 shadow-lg mb-6 overflow-x-auto">
            <a href="{{ route('booking.index', ['status' => 'all']) }}" 
               class="tab {{ $statusFilter === 'all' ? 'tab-active' : '' }}">
                📋 Semua ({{ $statusCounts['all'] }})
            </a>
            <a href="{{ route('booking.index', ['status' => 'pending']) }}" 
               class="tab {{ $statusFilter === 'pending' ? 'tab-active' : '' }}">
                ⏳ Pending ({{ $statusCounts['pending'] }})
            </a>
            <a href="{{ route('booking.index', ['status' => 'approved']) }}" 
               class="tab {{ $statusFilter === 'approved' ? 'tab-active' : '' }}">
                ✅ Disetujui ({{ $statusCounts['approved'] }})
            </a>
            <a href="{{ route('booking.index', ['status' => 'rejected']) }}" 
               class="tab {{ $statusFilter === 'rejected' ? 'tab-active' : '' }}">
                ❌ Ditolak ({{ $statusCounts['rejected'] }})
            </a>
        </div>

        @if($bookings->count() > 0)
            <!-- Bookings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($bookings as $booking)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                        <div class="card-body">
                            <!-- Status Badge -->
                            <div class="flex justify-between items-start mb-3">
                                <div class="badge badge-lg
                                    @if($booking->status === 'pending') badge-warning
                                    @elseif($booking->status === 'approved') badge-success
                                    @else badge-error
                                    @endif">
                                    @if($booking->status === 'pending') ⏳ Menunggu
                                    @elseif($booking->status === 'approved') ✅ Disetujui
                                    @else ❌ Ditolak
                                    @endif
                                </div>
                                <div class="text-xs opacity-70">
                                    {{ $booking->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <!-- Mahasiswa Info -->
                            <h3 class="card-title text-lg">{{ $booking->nama_mahasiswa }}</h3>
                            <div class="space-y-1 text-sm">
                                <p class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $booking->email_mahasiswa }}
                                </p>
                                @if($booking->nim_mahasiswa)
                                <p class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    NIM: {{ $booking->nim_mahasiswa }}
                                </p>
                                @endif
                            </div>

                            <div class="divider my-2"></div>

                            <!-- Schedule Info -->
                            <div class="space-y-2 text-sm">
                                <p class="flex items-center gap-2 font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $booking->tanggal_booking->format('d F Y') }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }}
                                </p>
                            </div>

                            <!-- Keperluan -->
                            <div class="mt-3">
                                <p class="text-xs font-semibold opacity-70 mb-1">Keperluan:</p>
                                <p class="text-sm">{{ Str::limit($booking->keperluan, 100) }}</p>
                            </div>

                            <!-- Alasan Reject (if rejected) -->
                            @if($booking->status === 'rejected' && $booking->alasan_reject)
                            <div class="alert alert-error mt-3">
                                <div class="text-xs">
                                    <p class="font-semibold">Alasan Penolakan:</p>
                                    <p>{{ $booking->alasan_reject }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Actions -->
                            @if($booking->status === 'pending')
                            <div class="card-actions justify-end mt-4 gap-2">
                                <!-- Approve -->
                                <form method="POST" action="{{ route('booking.approve', $booking->id) }}">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('Setujui booking ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Setujui
                                    </button>
                                </form>

                                <!-- Reject (Open Modal) -->
                                <button class="btn btn-error btn-sm" 
                                        onclick="rejectModal_{{ $booking->id }}.showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak
                                </button>

                                <!-- Reject Modal -->
                                <dialog id="rejectModal_{{ $booking->id }}" class="modal">
                                    <div class="modal-box">
                                        <h3 class="font-bold text-lg mb-4">❌ Tolak Booking</h3>
                                        <p class="mb-4">Berikan alasan penolakan untuk mahasiswa:</p>
                                        
                                        <form method="POST" action="{{ route('booking.reject', $booking->id) }}">
                                            @csrf
                                            <div class="form-control">
                                                <textarea name="alasan_reject" 
                                                          class="textarea textarea-bordered h-32" 
                                                          placeholder="Contoh: Jadwal bentrok dengan mengajar. Silakan pilih waktu lain."
                                                          required></textarea>
                                            </div>
                                            
                                            <div class="modal-action">
                                                <button type="button" 
                                                        class="btn btn-ghost" 
                                                        onclick="rejectModal_{{ $booking->id }}.close()">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-error">
                                                    Kirim & Tolak
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <form method="dialog" class="modal-backdrop">
                                        <button>close</button>
                                    </form>
                                </dialog>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $bookings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center py-20">
                    <div class="text-8xl mb-6">📝</div>
                    <h3 class="text-3xl font-bold mb-4">
                        @if($statusFilter === 'pending') Tidak Ada Booking Pending
                        @elseif($statusFilter === 'approved') Tidak Ada Booking Disetujui
                        @elseif($statusFilter === 'rejected') Tidak Ada Booking Ditolak
                        @else Belum Ada Booking
                        @endif
                    </h3>
                    <p class="text-lg opacity-70">
                        @if($statusFilter === 'all')
                            Belum ada mahasiswa yang mengajukan konsultasi
                        @else
                            Tidak ada booking dengan status ini
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
