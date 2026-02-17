<x-app-layout>
    <h1 class="text-3xl font-bold mb-6">Kelola Booking</h1>

    <div class="tabs tabs-boxed mb-6">
        <a href="{{ route('booking.index') }}" class="tab {{ !request('status') ? 'tab-active' : '' }}">Semua</a>
        <a href="{{ route('booking.index', ['status' => 'pending']) }}" class="tab {{ request('status') === 'pending' ? 'tab-active' : '' }}">Pending</a>
        <a href="{{ route('booking.index', ['status' => 'approved']) }}" class="tab {{ request('status') === 'approved' ? 'tab-active' : '' }}">Approved</a>
        <a href="{{ route('booking.index', ['status' => 'rejected']) }}" class="tab {{ request('status') === 'rejected' ? 'tab-active' : '' }}">Rejected</a>
    </div>

    @if($bookings->count() > 0)
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table">
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
                                <tr>
                                    <td>
                                        <div class="font-bold">{{ $booking->nama_mahasiswa }}</div>
                                        <div class="text-sm opacity-50">{{ $booking->nim }}</div>
                                    </td>
                                    <td>{{ $booking->tanggal_booking->format('d M Y') }}</td>
                                    <td>
                                        {{ $booking->jadwal->hari }}<br>
                                        <span class="text-sm">{{ $booking->jadwal->waktu_mulai }} - {{ $booking->jadwal->waktu_selesai }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'approved' ? 'success' : 'error') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($booking->isPending())
                                            <form method="POST" action="{{ route('booking.approve', $booking->id) }}" class="inline">
                                                @csrf
                                                <button class="btn btn-success btn-xs">Approve</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $bookings->links() }}
            </div>
        </div>
    @else
        <div class="alert">Belum ada booking</div>
    @endif
</x-app-layout>
