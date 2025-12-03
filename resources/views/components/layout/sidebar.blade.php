<aside class="w-64 bg-neutral-900 border-r border-neutral-800 px-6 py-6 flex flex-col gap-8">
    <div class="text-2xl font-bold tracking-tight">dYZæ Music</div>

    @php
        $nav = [
            ['label' => 'Home', 'route' => 'home'],
            ['label' => 'Library', 'route' => 'library'],
            ['label' => 'Upload', 'route' => 'upload.form'],
            ['label' => 'Playlist', 'route' => 'playlist.index'],
        ];
    @endphp

    <nav class="flex flex-col gap-2 text-sm">
        @foreach ($nav as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-2 px-3 py-2 rounded-lg transition
               {{ request()->routeIs($item['route']) ? 'bg-neutral-800 text-white' : 'text-neutral-300 hover:bg-neutral-800' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
