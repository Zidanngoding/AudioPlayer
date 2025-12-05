@extends('layouts.main')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold">Playlist</h2>
            <p class="text-neutral-400 text-sm mt-1">Session based playlist (local to this browser).</p>
        </div>
        <div class="flex gap-3">
            <button type="button" class="px-4 py-2 bg-purple-600 hover:bg-purple-500 rounded-md text-sm font-semibold js-queue" data-target="playlist-list">Play all</button>
            <a href="{{ route('library') }}" class="px-4 py-2 bg-neutral-800 rounded-md text-sm text-white hover:bg-neutral-700">Back to library</a>
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-md border border-green-700 bg-green-900/40 text-green-200 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4" data-tracklist="playlist-list">
        @forelse ($songs as $song)
            @php
                $fileUrl = $song->file_url ?? ($song->file_path ? asset($song->file_path) : '');
                $cover = $song->cover_url ?? ($song->cover ? asset($song->cover) : asset('defaultcover.jpg'));
            @endphp
            <div class="p-4 bg-neutral-900/60 border border-neutral-800 rounded-lg flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <button type="button"
                            class="w-16 h-16 rounded-lg overflow-hidden bg-neutral-800 js-play"
                            data-src="{{ $fileUrl }}"
                            data-title="{{ $song->title }}"
                            data-artist="{{ $song->artist }}"
                            data-cover="{{ $cover }}"
                            data-song-id="{{ $song->id }}">
                        @if ($cover)
                            <img src="{{ $cover }}" alt="{{ $song->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-neutral-700 to-neutral-900"></div>
                        @endif
                    </button>
                    <div>
                        <p class="text-lg font-semibold">{{ $song->title }}</p>
                        <p class="text-sm text-neutral-400">{{ $song->artist }} · {{ $song->category }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <form action="{{ route('playlist.destroy', $song) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-2 bg-neutral-800 rounded-md text-sm hover:bg-neutral-700" type="submit">Remove</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-neutral-400 text-sm">Playlist masih kosong.</p>
        @endforelse
    </div>
</div>
@endsection
