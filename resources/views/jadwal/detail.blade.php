<!DOCTYPE html>
<html lang="id" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $dosen->name }} - Lab WICIDA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200">
    <!-- Navbar -->
    <div class="navbar bg-base-100 shadow-lg">
        <div class="navbar-start">
            <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl">
                🎓 Lab WICIDA
            </a>
        </div>
        <div class="navbar-end">
            <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Dosen Header -->
            <div class="card bg-base-100 shadow-xl mb-8">
                <div class="card-body">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-20">
                                    <span class="text-3xl font-bold">{{ substr($dosen->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div>
                                <h2 class="card-title text-3xl">{{ $dosen->name }}</h2>
                                <p class="text-sm opacity-70">NIP: {{ $dosen->nip ?? '-' }}</p>
                                <div class="badge badge-primary mt-2">
                                    {{ ucfirst(str_replace('_', ' ', $dosen->role)) }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="badge badge-lg text-lg p-6
                            @if($dosen->status && $dosen->status->status === 'Ada') badge-success
                            @elseif($dosen->status && $dosen->status->status === 'Mengajar') badge-warning
                            @elseif($dosen->status && $dosen->status->status === 'Konsultasi') badge-info
                            @else badge-error
                            @endif">
                            @if($dosen->status)
                                @if($dosen->status->status === 'Ada') 🟢 Ada
                                @elseif($dosen->status->status === 'Mengajar') 🟡 Mengajar
                                @elseif($dosen->status->status === 'Konsultasi') 🔵 Konsultasi
                                @else 🔴 Tidak Ada
                                @endif
                            @else
                                ⚪ Status N/A
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Jadwal Mingguan -->
                <div>
                    <h3 class="text-3xl font-bold mb-6">📅 Jadwal Mingguan</h3>
                    
                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    @endphp

                    @foreach($days as $day)
                        <div class="collapse collapse-arrow bg-base-100 shadow mb-3">
                            <input type="checkbox" {{ isset($jadwalsByDay[$day]) && $jadwalsByDay[$day]->count() > 0 ? 'checked' : '' }} />
                            <div class="collapse-title text-xl font-medium flex justify-between items-center">
                                <span>{{ $day }}</span>
                                @if(isset($jadwalsByDay[$day]) && $jadwalsByDay[$day]->count() > 0)
                                    <div class="badge badge-primary">{{ $jadwalsByDay[$day]->count() }} jadwal</div>
                                @endif
                            </div>
                            <div class="collapse-content">
                                @if(isset($jadwalsByDay[$day]) && $jadwalsByDay[$day]->count() > 0)
                                    <div class="space-y-3 mt-2">
                                        @foreach($jadwalsByDay[$day] as $jadwal)
                                            <div class="card bg-base-200">
                                                <div class="card-body p-4">
                                                    <div class="flex items-start gap-3">
                                                        <div class="text-2xl">
                                                            @if($jadwal->kegiatan === 'Mengajar') 📚
                                                            @elseif($jadwal->kegiatan === 'Konsultasi') 💬
                                                            @elseif($jadwal->kegiatan === 'Rapat') 👥
                                                            @else 📌
                                                            @endif
                                                        </div>
                                                        <div class="flex-1">
                                                            <p class="font-bold text-lg">
                                                                ⏰ {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                                            </p>
                                                            <p class="text-base font-semibold">{{ $jadwal->kegiatan }}</p>
                                                            @if($jadwal->ruangan)
                                                                <p class="text-sm">📍 {{ $jadwal->ruangan }}</p>
                                                            @endif
                                                            @if($jadwal->keterangan)
                                                                <p class="text-sm opacity-70 mt-1">{{ $jadwal->keterangan }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm opacity-70 py-2">Tidak ada jadwal untuk hari ini</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Form Booking -->
                <div id="booking">
                    <h3 class="text-3xl font-bold mb-6">📝 Booking Konsultasi</h3>
                    
                    <div class="card bg-base-100 shadow-xl sticky top-24">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('booking.store.public', $dosen->id) }}">
                                @csrf

                                <!-- Nama Mahasiswa -->
                                <div class="form-control mb-4">
                                    <label class="label">
                                        <span class="label-text font-semibold">Nama Lengkap *</span>
                                    </label>
                                    <input type="text" 
                                           name="nama_mahasiswa" 
                                           placeholder="Masukkan nama lengkap"
                                           class="input input-bordered @error('nama_mahasiswa') input-error @enderror" 
                                           value="{{ old('nama_mahasiswa') }}" 
                                           required>
                                    @error('nama_mahasiswa')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-control mb-4">
                                    <label class="label">
                                        <span class="label-text font-semibold">Email *</span>
                                    </label>
                                    <input type="email" 
                                           name="email_mahasiswa" 
                                           placeholder="email@student.ac.id"
                                           class="input input-bordered @error('email_mahasiswa') input-error @enderror" 
                                           value="{{ old('email_mahasiswa') }}" 
                                           required>
                                    @error('email_mahasiswa')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <!-- NIM -->
                                <div class="form-control mb-4">
                                    <label class="label">
                                        <span class="label-text font-semibold">NIM (Opsional)</span>
                                    </label>
                                    <input type="text" 
                                           name="nim_mahasiswa" 
                                           placeholder="Masukkan NIM"
                                           class="input input-bordered" 
                                           value="{{ old('nim_mahasiswa') }}">
                                </div>

                                <!-- Tanggal -->
                                <div class="form-control mb-4">
                                    <label class="label">
                                        <span class="label-text font-semibold">Tanggal Booking *</span>
                                    </label>
                                    <input type="date" 
                                           name="tanggal_booking" 
                                           class="input input-bordered @error('tanggal_booking') input-error @enderror" 
                                           value="{{ old('tanggal_booking') }}" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                           required>
                                    @error('tanggal_booking')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                    <label class="label">
                                        <span class="label-text-alt">Minimal booking H+1 (besok)</span>
                                    </label>
                                </div>

                                <!-- Jam -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold">Jam Mulai *</span>
                                        </label>
                                        <input type="time" 
                                               name="jam_mulai" 
                                               class="input input-bordered @error('jam_mulai') input-error @enderror" 
                                               value="{{ old('jam_mulai') }}" 
                                               required>
                                        @error('jam_mulai')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold">Jam Selesai *</span>
                                        </label>
                                        <input type="time" 
                                               name="jam_selesai" 
                                               class="input input-bordered @error('jam_selesai') input-error @enderror" 
                                               value="{{ old('jam_selesai') }}" 
                                               required>
                                        @error('jam_selesai')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Keperluan -->
                                <div class="form-control mb-6">
                                    <label class="label">
                                        <span class="label-text font-semibold">Keperluan Konsultasi *</span>
                                    </label>
                                    <textarea name="keperluan" 
                                              class="textarea textarea-bordered h-32 @error('keperluan') textarea-error @enderror" 
                                              placeholder="Jelaskan keperluan konsultasi Anda (min. 10 karakter)"
                                              required>{{ old('keperluan') }}</textarea>
                                    @error('keperluan')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-full btn-lg">
                                    📩 Kirim Booking
                                </button>

                                <p class="text-sm text-center mt-4 opacity-70">
                                    * Wajib diisi. Tunggu konfirmasi dari dosen.
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer footer-center p-10 bg-base-300 text-base-content mt-16">
        <aside>
            <p class="font-bold">Lab WICIDA © {{ date('Y') }}</p>
            <p>Sistem Jadwal Dosen</p>
        </aside>
    </footer>
</body>
</html>
