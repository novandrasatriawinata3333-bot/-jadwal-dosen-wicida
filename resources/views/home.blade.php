<!DOCTYPE html>
<html lang="id" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lab WICIDA - Sistem Jadwal Dosen</title>
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
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="{{ route('home') }}" class="active">🏠 Home</a></li>
            </ul>
        </div>
        <div class="navbar-end">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                    📊 Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                    🔐 Login Dosen
                </a>
            @endauth
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero min-h-[50vh] bg-gradient-to-r from-primary to-secondary text-primary-content">
        <div class="hero-content text-center">
            <div class="max-w-2xl">
                <h1 class="text-6xl font-bold mb-4">🎓 Lab WICIDA</h1>
                <p class="text-2xl mb-2 font-semibold">Sistem Jadwal Dosen</p>
                <p class="text-lg opacity-90 mb-6">Transparansi & Kemudahan Konsultasi untuk Mahasiswa</p>
                <div class="flex gap-4 justify-center">
                    <a href="#dosen-list" class="btn btn-neutral btn-lg">
                        👥 Lihat Dosen
                    </a>
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-outline btn-lg">
                        🔐 Login
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center">
                    <div class="text-5xl mb-4">📅</div>
                    <h3 class="card-title justify-center">Jadwal Real-Time</h3>
                    <p>Lihat jadwal dosen secara real-time dan update terkini</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center">
                    <div class="text-5xl mb-4">🔔</div>
                    <h3 class="card-title justify-center">Status Live</h3>
                    <p>Ketahui status dosen: Ada, Mengajar, Konsultasi, atau Tidak Ada</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center">
                    <div class="text-5xl mb-4">📝</div>
                    <h3 class="card-title justify-center">Booking Mudah</h3>
                    <p>Ajukan konsultasi dengan mudah dan tunggu persetujuan</p>
                </div>
            </div>
        </div>

        <!-- Dosen List -->
        <div id="dosen-list">
            <h2 class="text-4xl font-bold text-center mb-12">👨‍🏫 Daftar Dosen Lab WICIDA</h2>

            @if($dosens->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($dosens as $dosen)
                        <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                            <div class="card-body">
                                <!-- Header -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary text-primary-content rounded-full w-16">
                                            <span class="text-2xl font-bold">{{ substr($dosen->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <div class="badge badge-lg
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

                                <!-- Info -->
                                <h2 class="card-title text-lg">{{ $dosen->name }}</h2>
                                <p class="text-sm opacity-70">NIP: {{ $dosen->nip ?? '-' }}</p>
                                <div class="badge badge-outline badge-primary">
                                    {{ ucfirst(str_replace('_', ' ', $dosen->role)) }}
                                </div>

                                <!-- Stats -->
                                <div class="stats stats-vertical shadow mt-4">
                                    <div class="stat p-3">
                                        <div class="stat-title text-xs">Total Jadwal</div>
                                        <div class="stat-value text-2xl">{{ $dosen->jadwals->count() }}</div>
                                    </div>
                                </div>

                                <div class="divider my-2"></div>

                                <!-- Actions -->
                                <div class="card-actions justify-between">
                                    <a href="{{ route('dosen.show', $dosen->id) }}" 
                                       class="btn btn-primary btn-sm flex-1">
                                        📅 Lihat Jadwal
                                    </a>
                                    <a href="{{ route('dosen.show', $dosen->id) }}#booking" 
                                       class="btn btn-outline btn-sm flex-1">
                                        📝 Booking
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body text-center py-20">
                        <div class="text-8xl mb-6">📚</div>
                        <h3 class="text-3xl font-bold mb-4">Belum Ada Data Dosen</h3>
                        <p class="text-lg opacity-70 mb-6">Database masih kosong. Jalankan seeder untuk menambahkan data.</p>
                        <div class="mockup-code bg-base-300 max-w-md mx-auto text-left">
                            <pre><code>php artisan migrate:fresh --seed</code></pre>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer footer-center p-10 bg-base-300 text-base-content">
        <aside>
            <p class="font-bold text-lg">Lab WICIDA © {{ date('Y') }}</p>
            <p>Sistem Jadwal Dosen - Universitas</p>
            <p class="text-sm opacity-70">Developed with ❤️ for better education</p>
        </aside>
    </footer>
</body>
</html>
