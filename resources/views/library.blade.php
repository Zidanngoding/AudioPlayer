@extends('layouts.main')

@section('content')

<h2 class="text-3xl font-bold text-white mb-6">Library Lagu</h2>

@foreach ($songs as $song)
    <div class="mb-6 p-4 bg-neutral-900 rounded-lg border border-neutral-700">

        {{-- JUDUL --}}
        <p class="text-xl font-semibold text-white">{{ $song->title }}</p>
        <p class="text-neutral-400 text-sm">Genre: {{ $song->category }}</p>
        <p class="text-neutral-500 text-sm mb-3">Uploader: {{ $song->uploader }}</p>

        {{-- AUDIO PLAYER --}}
        <audio controls class="w-full mb-4">
            <source src="/{{ $song->file_path }}" type="audio/mpeg">
        </audio>

        {{-- ACTION BUTTONS --}}
        <div class="flex gap-3">

            {{-- EDIT --}}
            <a href="{{ route('songs.edit', $song->id) }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                Edit
            </a>

            {{-- DELETE --}}
            <form action="{{ route('songs.destroy', $song->id) }}" method="POST"
                  onsubmit="return confirm('Hapus lagu ini?')">
                @csrf
                @method('DELETE')

                <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                    Delete
                </button>
            </form>

        </div>

    </div>
@endforeach

@endsection