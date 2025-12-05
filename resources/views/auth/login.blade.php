<x-guest-layout>
    <div class="space-y-6">
        <div class="space-y-2">
            <p class="text-sm text-neutral-400">Welcome back</p>
            <h2 class="text-3xl font-bold">Masuk ke akunmu</h2>
            <p class="text-sm text-neutral-400">Belum punya akun?
                <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300 font-semibold">Sign up</a>
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <label for="email" class="text-sm text-neutral-200">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="w-full bg-neutral-950 border border-neutral-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500"
                    placeholder="you@example.com"
                >
                <x-input-error :messages="$errors->get('email')" class="text-red-400 text-sm" />
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm text-neutral-200">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full bg-neutral-950 border border-neutral-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500"
                    placeholder="••••••••"
                >
                <x-input-error :messages="$errors->get('password')" class="text-red-400 text-sm" />
            </div>

            <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="inline-flex items-center gap-2 text-neutral-300">
                    <input id="remember_me" type="checkbox" class="rounded border-neutral-700 bg-neutral-950 text-purple-500 focus:ring-purple-500" name="remember">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-purple-300 hover:text-purple-200" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full mt-2 bg-purple-600 hover:bg-purple-500 text-white font-semibold rounded-xl px-4 py-3 text-sm transition">
                Log in
            </button>
        </form>
    </div>
</x-guest-layout>
