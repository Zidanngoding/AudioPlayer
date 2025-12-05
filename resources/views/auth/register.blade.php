<x-guest-layout>
    <div class="space-y-6">
        <div class="space-y-2">
            <p class="text-sm text-neutral-400">Create account</p>
            <h2 class="text-3xl font-bold">Sign up to Cloud Music</h2>
            <p class="text-sm text-neutral-400">Sudah punya akun?
                <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300 font-semibold">Log in</a>
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <label for="name" class="text-sm text-neutral-200">Nama</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="w-full bg-neutral-950 border border-neutral-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500"
                    placeholder="Nama lengkap"
                >
                <x-input-error :messages="$errors->get('name')" class="text-red-400 text-sm" />
            </div>

            <div class="space-y-2">
                <label for="email" class="text-sm text-neutral-200">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
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
                    autocomplete="new-password"
                    class="w-full bg-neutral-950 border border-neutral-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500"
                    placeholder="••••••••"
                >
                <x-input-error :messages="$errors->get('password')" class="text-red-400 text-sm" />
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm text-neutral-200">Konfirmasi Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full bg-neutral-950 border border-neutral-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-purple-500"
                    placeholder="Ulangi password"
                >
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-400 text-sm" />
            </div>

            <button type="submit" class="w-full mt-2 bg-purple-600 hover:bg-purple-500 text-white font-semibold rounded-xl px-4 py-3 text-sm transition">
                Sign up
            </button>
        </form>
    </div>
</x-guest-layout>
