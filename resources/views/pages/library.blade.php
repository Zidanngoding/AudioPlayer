@extends('layouts.main')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold">Library</h2>
            @if (isset($query) && $query)
                <p class="text-sm text-neutral-400 mt-1">Hasil pencarian untuk "{{ $query }}"</p>
            @endif
        </div>
        <div class="flex gap-3">
            <button type="button" class="px-4 py-2 bg-purple-600 hover:bg-purple-500 rounded-md text-sm font-semibold js-queue" data-target="library-list">Play all</button>
            <a href="{{ route('upload.form') }}" class="px-4 py-2 bg-neutral-800 rounded-md text-sm text-white hover:bg-neutral-700">Upload</a>
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-md border border-green-700 bg-green-900/40 text-green-200 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4" data-tracklist="library-list">
        @forelse ($songs as $song)
            @php
                $cover = $song->cover ? asset($song->cover) : '';
            @endphp
            <div class="p-4 bg-neutral-900/60 border border-neutral-800 rounded-lg flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <button type="button"
                            class="w-16 h-16 rounded-lg overflow-hidden bg-neutral-800 js-play"
                            data-src="{{ asset($song->file_path) }}"
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
                        <p class="text-xs text-neutral-500">Uploader: {{ $song->uploader }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <form action="{{ route('playlist.store', $song) }}" method="POST">
                        @csrf
                        <button class="px-3 py-2 bg-neutral-800 rounded-md text-sm hover:bg-neutral-700" type="submit">Add to playlist</button>
                    </form>

                    <a href="{{ route('songs.edit', $song) }}" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 rounded-md text-sm text-white">Edit</a>

                    <form action="{{ route('songs.destroy', $song) }}" method="POST" onsubmit="return confirm('Hapus lagu ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-2 bg-red-600 hover:bg-red-500 rounded-md text-sm text-white" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-neutral-400 text-sm">Belum ada lagu.</p>
        @endforelse
    </div>
</div>
@endsection
