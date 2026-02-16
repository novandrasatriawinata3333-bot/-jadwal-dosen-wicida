<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="cupcake">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lab WICIDA') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-base-200">
    @include('layouts.navigation')
    
    <!-- Page Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mb-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
            <div class="alert alert-error mb-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="footer footer-center p-10 bg-base-300 text-base-content mt-16">
        <aside>
            <p class="font-bold">Lab WICIDA © {{ date('Y') }}</p>
            <p>Sistem Jadwal Dosen - Transparansi & Kemudahan</p>
        </aside>
    </footer>

    @stack('scripts')
</body>
</html>
