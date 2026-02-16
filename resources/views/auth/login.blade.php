<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-3xl font-bold">🔐 Login Dosen</h2>
        <p class="text-sm opacity-70 mt-2">Masuk ke dashboard Lab WICIDA</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text font-semibold">Email</span>
            </label>
            <input type="email" 
                   name="email" 
                   placeholder="email@lab-wicida.ac.id"
                   class="input input-bordered @error('email') input-error @enderror" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus>
            @error('email')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text font-semibold">Password</span>
            </label>
            <input type="password" 
                   name="password" 
                   placeholder="••••••••"
                   class="input input-bordered @error('password') input-error @enderror" 
                   required>
            @error('password')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-control mb-6">
            <label class="label cursor-pointer justify-start gap-3">
                <input type="checkbox" name="remember" class="checkbox checkbox-primary" />
                <span class="label-text">Ingat saya</span>
            </label>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-4">
            <button type="submit" class="btn btn-primary btn-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Login
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="btn btn-ghost btn-sm">
                    Lupa password?
                </a>
            @endif
        </div>
    </form>

    <!-- Demo Credentials -->
    <div class="divider">Akun Demo</div>
    <div class="alert alert-info">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="text-xs">
            <p><strong>Email:</strong> budi@lab-wicida.ac.id</p>
            <p><strong>Password:</strong> password</p>
        </div>
    </div>
</x-guest-layout>
