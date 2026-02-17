<x-app-layout>
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold mb-2">Daftar Dosen Lab WICIDA</h1>
        <p class="text-lg text-gray-600">Pilih dosen untuk melihat jadwal dan booking konsultasi</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($dosens as $dosen)
            <div class="card bg-base-100 shadow-xl">
                <figure class="px-10 pt-10">
                    <div class="avatar">
                        <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="{{ $dosen->photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($dosen->name) }}" />
                        </div>
                    </div>
                </figure>
                <div class="card-body items-center text-center">
                    <h2 class="card-title">{{ $dosen->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $dosen->email }}</p>
                    <p class="text-xs">NIP: {{ $dosen->nip }}</p>
                    
                    @if($dosen->status)
                        <div class="badge 
                            @if($dosen->status->status === 'Ada') badge-success
                            @elseif($dosen->status->status === 'Tidak Ada') badge-error
                            @elseif($dosen->status->status === 'Rapat') badge-warning
                            @else badge-info
                            @endif">
                            {{ $dosen->status->status }}
                        </div>
                    @endif

                    <div class="card-actions mt-4">
                        <a href="{{ route('dosen.show', $dosen->id) }}" class="btn btn-primary btn-sm">
                            Lihat Jadwal & Booking
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
