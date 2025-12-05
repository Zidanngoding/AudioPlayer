<header class="border-b border-neutral-800 px-8 py-4 flex items-center gap-4 bg-neutral-950 sticky top-0 z-30">
    @if (!request()->routeIs('upload.form'))
        <form action="{{ route('songs.search') }}" method="GET" class="w-full max-w-xl">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Search songs, artists..."
                class="w-full bg-neutral-900 border border-neutral-800 rounded-full px-4 py-2 text-sm text-white focus:outline-none focus:border-purple-500"
            >
        </form>
    @endif

    <div class="flex items-center gap-3 ml-auto">
        <div class="text-xs text-neutral-500">
            Cloud Music
        </div>

        @auth
            @php
                $initial = strtoupper(substr(auth()->user()->name ?? auth()->user()->email ?? 'U', 0, 1));
            @endphp
            <details class="relative">
                <summary class="list-none w-10 h-10 rounded-full bg-neutral-900 border border-neutral-800 flex items-center justify-center font-semibold cursor-pointer hover:border-purple-500 [&::-webkit-details-marker]:hidden">
                    {{ $initial }}
                </summary>
                <div class="absolute right-0 mt-2 w-48 bg-neutral-900 border border-neutral-800 rounded-xl shadow-xl py-2">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-neutral-200 hover:bg-neutral-800">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-300 hover:bg-neutral-800">
                            Logout
                        </button>
                    </form>
                </div>
            </details>
        @else
            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="text-sm text-neutral-300 hover:text-white">Login</a>
                <a href="{{ route('register') }}" class="text-sm text-purple-400 hover:text-purple-300">Register</a>
            </div>
        @endauth
    </div>
</header>
