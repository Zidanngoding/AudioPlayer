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
    <div class="flex-1 text-right text-xs text-neutral-500">
        Cloud Music
    </div>
</header>
