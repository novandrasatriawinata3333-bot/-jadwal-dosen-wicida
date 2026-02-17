<x-app-layout>
    <h1 class="text-3xl font-bold mb-6">Dashboard Dosen</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Pending</div>
                <div class="stat-value text-warning">{{ $stats['pending'] }}</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Approved</div>
                <div class="stat-value text-success">{{ $stats['approved'] }}</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Rejected</div>
                <div class="stat-value text-error">{{ $stats['rejected'] }}</div>
            </div>
        </div>
    </div>

    <div class="flex gap-4 mb-6">
        <a href="{{ route('jadwal.index') }}" class="btn btn-primary">Kelola Jadwal</a>
        <a href="{{ route('booking.index') }}" class="btn btn-secondary">Kelola Booking</a>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Booking Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Tanggal</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>
                                    <div class="font-bold">{{ $booking->nama_mahasiswa }}</div>
                                    <div class="text-sm opacity-50">{{ $booking->nim }}</div>
                                </td>
                                <td>{{ $booking->tanggal_booking->format('d M Y') }}</td>
                                <td>{{ Str::limit($booking->keperluan, 50) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($booking->status === 'pending') badge-warning
                                        @elseif($booking->status === 'approved') badge-success
                                        @elseif($booking->status === 'rejected') badge-error
                                        @else badge-ghost
                                        @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->isPending())
                                        <form method="POST" action="{{ route('booking.approve', $booking->id) }}" class="inline">
                                            @csrf
                                            <button class="btn btn-success btn-xs">Approve</button>
                                        </form>
                                        <button class="btn btn-error btn-xs" onclick="reject_modal_{{ $booking->id }}.showModal()">Reject</button>
                                        
                                        <dialog id="reject_modal_{{ $booking->id }}" class="modal">
                                            <form method="POST" action="{{ route('booking.reject', $booking->id) }}" class="modal-box">
                                                @csrf
                                                <h3 class="font-bold text-lg">Alasan Reject</h3>
                                                <textarea name="alasan_reject" class="textarea textarea-bordered w-full mt-2" required></textarea>
                                                <div class="modal-action">
                                                    <button type="submit" class="btn btn-error">Reject</button>
                                                    <button type="button" class="btn" onclick="reject_modal_{{ $booking->id }}.close()">Batal</button>
                                                </div>
                                            </form>
                                        </dialog>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Belum ada booking</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $bookings->links() }}
        </div>
    </div>
</x-app-layout>
