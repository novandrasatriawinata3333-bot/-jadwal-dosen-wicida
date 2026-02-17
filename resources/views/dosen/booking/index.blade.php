<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Booking</h1>
    </div>

    <!-- Filter Tabs -->
    <div class="tabs tabs-boxed mb-6">
        <a href="{{ route('booking.index') }}" class="tab {{ !request('status') || request('status') === 'all' ? 'tab-active' : '' }}">Semua</a>
        <a href="{{ route('booking.index', ['status' => 'pending']) }}" class="tab {{ request('status') === 'pending' ? 'tab-active' : '' }}">Pending</a>
        <a href="{{ route('booking.index', ['status' => 'approved']) }}" class="tab {{ request('status') === 'approved' ? 'tab-active' : '' }}">Approved</a>
        <a href="{{ route('booking.index', ['status' => 'rejected']) }}" class="tab {{ request('status') === 'rejected' ? 'tab-active' : '' }}">Rejected</a>
    </div>

    @if($bookings->count() > 0)
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table table-compact">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Tanggal</th>
                                <th>Jadwal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr class="hover">
                                    <td>
                                        <div class="font-bold">{{ $booking->nama_mahasiswa }}</div>
                                        <div class="text-sm opacity-50">{{ $booking->nim }}</div>
                                        <div class="text-sm opacity-50">{{ $booking->email_mahasiswa }}</div>
                                    </td>
                                    <td>{{ $booking->tanggal_booking->format('d M Y') }}</td>
                                    <td>
                                        <div>{{ $booking->jadwal->hari }}</div>
                                        <div class="text-sm">{{ $booking->jadwal->waktu_mulai }} - {{ $booking->jadwal->waktu_selesai }}</div>
                                    </td>
                                    <td>
                                        @switch($booking->status)
                                            @case('pending')
                                                <span class="badge badge-warning">Pending</span>
                                                @break
                                            @case('approved')
                                                <span class="badge badge-success">Approved</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge badge-error">Rejected</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge badge-ghost">Cancelled</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($booking->status === 'pending')
                                            <div class="flex gap-1">
                                                <form method="POST" action="{{ route('booking.approve', $booking) }}" class="inline">
                                                    @csrf
                                                    <button class="btn btn-success btn-xs">✓ Approve</button>
                                                </form>
                                                <button class="btn btn-error btn-xs" onclick="openRejectModal({{ $booking->id }})">✗ Reject</button>
                                            </div>
                                        @else
                                            <span class="text-sm opacity-50">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <span>Belum ada booking yang masuk</span>
        </div>
    @endif

    <!-- Reject Modal -->
    <dialog id="reject-modal" class="modal">
        <form method="POST" action="" class="modal-box" id="reject-form">
            @csrf
            <h3 class="font-bold text-lg">Alasan Penolakan</h3>
            <textarea name="alasan_reject" class="textarea textarea-bordered w-full mt-2" rows="4" placeholder="Masukkan alasan penolakan..." required></textarea>
            <div class="modal-action">
                <button class="btn btn-error">Tolak</button>
                <button type="button" class="btn" onclick="reject_modal.close()">Batal</button>
            </div>
        </form>
    </dialog>

    <script>
        function openRejectModal(bookingId) {
            const form = document.getElementById('reject-form');
            form.action = `/booking/${bookingId}/reject`;
            reject_modal.showModal();
        }
    </script>
</x-app-layout>
