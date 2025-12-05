@props(['song'])

@php
    $fileUrl = $song->file_url ?? ($song->file_path ? asset($song->file_path) : '');
    $cover = $song->cover_url ?? ($song->cover ? asset($song->cover) : asset('defaultcover.jpg'));
@endphp

<button type="button"
        class="w-40 text-left space-y-2 group js-play"
        data-src="{{ $fileUrl }}"
        data-title="{{ $song->title }}"
        data-artist="{{ $song->artist }}"
        data-cover="{{ $cover }}"
        data-song-id="{{ $song->id }}">
    <div class="w-40 h-40 rounded-xl overflow-hidden bg-neutral-800 group-hover:scale-[1.02] transition-transform">
        @if ($cover)
            <img src="{{ $cover }}" alt="{{ $song->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br from-neutral-700 to-neutral-900"></div>
        @endif
    </div>

    <p class="text-white font-semibold truncate">{{ $song->title }}</p>
    <p class="text-neutral-400 text-sm truncate">{{ $song->artist }}</p>
</button>
