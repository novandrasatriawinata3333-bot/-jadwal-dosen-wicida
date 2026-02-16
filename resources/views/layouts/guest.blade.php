<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="cupcake">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lab WICIDA') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-primary to-secondary flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <h1 class="text-5xl font-bold text-white drop-shadow-lg">🎓</h1>
                <h2 class="text-2xl font-bold text-white mt-2">Lab WICIDA</h2>
            </a>
        </div>

        <!-- Card -->
        <div class="card bg-base-100 shadow-2xl">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer Link -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-white hover:text-base-100 transition">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
