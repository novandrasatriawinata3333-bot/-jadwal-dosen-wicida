<div class="navbar bg-base-100 shadow-lg sticky top-0 z-50">
    <div class="navbar-start">
        <!-- Mobile Dropdown -->
        <div class="dropdown">
            <label tabindex="0" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </label>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                @auth
                    <li><a href="{{ route('dashboard') }}">📊 Dashboard</a></li>
                    <li><a href="{{ route('jadwal.index') }}">📅 Jadwal</a></li>
                    <li><a href="{{ route('booking.index') }}">📝 Booking</a></li>
                @else
                    <li><a href="{{ route('home') }}">🏠 Home</a></li>
                @endauth
            </ul>
        </div>
        <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl">
            🎓 Lab WICIDA
        </a>
    </div>
    
    <!-- Desktop Menu -->
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            @auth
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 Dashboard</a></li>
                <li><a href="{{ route('jadwal.index') }}" class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }}">📅 Jadwal</a></li>
                <li><a href="{{ route('booking.index') }}" class="{{ request()->routeIs('booking.*') ? 'active' : '' }}">📝 Booking</a></li>
            @else
                <li><a href="{{ route('home') }}">🏠 Home</a></li>
            @endauth
        </ul>
    </div>
    
    <!-- Right Side -->
    <div class="navbar-end">
        @auth
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full bg-primary text-primary-content flex items-center justify-center">
                        <span class="text-xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li class="menu-title">
                        <span>{{ Auth::user()->name }}</span>
                        <span class="text-xs opacity-60">{{ Auth::user()->role }}</span>
                    </li>
                    <li><a href="{{ route('profile.edit') }}">👤 Edit Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left">🚪 Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                🔐 Login Dosen
            </a>
        @endauth
    </div>
</div>
