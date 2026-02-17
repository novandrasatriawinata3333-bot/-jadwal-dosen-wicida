<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('home') }}" class="btn btn-ghost">← Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Profile Dosen -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center gap-4">
                    <div class="avatar">
                        <div class="w-24 rounded-full ring ring-primary">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($dosen->name) }}" />
                        </div>
                    </div>
                    <div>
                        <h2 class="card-title text-2xl">{{ $dosen->name }}</h2>
                        <p class="text-lg">{{ $dosen->email }}</p>
                        @if($dosen->status)
                            <div class="badge badge-lg mt-2 badge-{{ $dosen->status->status === 'Ada' ? 'success' : 'error' }}">
                                Status: {{ $dosen->status->status }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Booking -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title">📅 Booking Konsultasi</h3>
                <form method="POST" action="{{ route('booking.store.public', $dosen->id) }}">
                    @csrf
                    
                    <input type="hidden" name="dosen_id" value="{{ $dosen->id }}" />
                    
                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">Pilih Jadwal</span></label>
                        <select name="jadwal_id" class="select select-bordered" required>
                            <option value="">Pilih jadwal</option>
                            @foreach($dosen->jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}">
                                    {{ $jadwal->hari }} {{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }} ({{ $jadwal->ruangan }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">Tanggal Booking</span></label>
                        <input type="date" name="tanggal_booking" class="input input-bordered" min="{{ now()->format('Y-m-d') }}" required />
                    </div>

                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">Nama Lengkap</span></label>
                        <input type="text" name="nama_mahasiswa" class="input input-bordered" required />
                    </div>

                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">NIM</span></label>
                        <input type="text" name="nim" class="input input-bordered" required />
                    </div>

                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">Email</span></label>
                        <input type="email" name="email_mahasiswa" class="input input-bordered" required />
                    </div>

                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">No. HP</span></label>
                        <input type="tel" name="no_hp" class="input input-bordered" required />
                    </div>

                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">Keperluan Konsultasi</span></label>
                        <textarea name="keperluan" class="textarea textarea-bordered" rows="4" placeholder="Jelaskan keperluan konsultasi Anda..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full">📋 Booking Sekarang</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Jadwal List -->
    @if($dosen->jadwals->count() > 0)
        <div class="divider mt-12">📋 Jadwal Tersedia</div>
        <div class="grid gap-4">
            @foreach($dosen->jadwals as $jadwal)
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h4 class="font-bold text-lg">{{ $jadwal->hari }}</h4>
                        <p class="text-xl">{{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</p>
                        <p class="text-sm opacity-70">{{ $jadwal->ruangan }}</p>
                        <p>{{ $jadwal->keterangan }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
