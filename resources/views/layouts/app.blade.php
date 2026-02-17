<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lab WICIDA') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200">
    <div class="navbar bg-primary text-primary-content">
        <div class="flex-1">
            <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl">Lab WICIDA</a>
        </div>
        <div class="flex-none">
            @auth
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" />
                        </div>
                    </label>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('jadwal.index') }}">Kelola Jadwal</a></li>
                        <li><a href="{{ route('booking.index') }}">Kelola Booking</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
            @endauth
        </div>
    </div>

    <main class="container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="alert alert-success mb-4">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error mb-4">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>
</body>
</html>
