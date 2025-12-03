@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h2 class="text-3xl font-bold">Edit Lagu</h2>
        <p class="text-neutral-400 text-sm mt-1">{{ $song->title }}</p>
    </div>

    <form action="{{ route('songs.update', $song) }}" method="POST" enctype="multipart/form-data" data-turbo="false" class="bg-neutral-900/60 border border-neutral-800 rounded-xl p-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">Judul Lagu</label>
            <input type="text" name="title" value="{{ $song->title }}" class="w-full bg-neutral-950 border border-neutral-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500" required>
        </div>

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">Nama Artis</label>
            <input type="text" name="artist" value="{{ $song->artist }}" class="w-full bg-neutral-950 border border-neutral-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500" required>
        </div>

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">Genre</label>
            <select name="category" class="w-full bg-neutral-950 border border-neutral-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500" required>
                @foreach ($genres as $genre)
                    <option value="{{ $genre }}" @selected($song->category === $genre)>{{ $genre }}</option>
                @endforeach
            </select>
        </div>

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">Cover (opsional)</label>
            <input type="file" name="cover" accept="image/*" class="w-full text-sm text-neutral-400">
            @if ($song->cover)
                <p class="text-xs text-neutral-500">Current: {{ $song->cover }}</p>
            @endif
        </div>

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">File Lagu (MP3)</label>
            <input type="file" name="file" accept=".mp3" class="w-full text-sm text-neutral-400">
            <p class="text-xs text-neutral-500">Biarkan kosong jika tidak ingin mengganti file.</p>
        </div>

        <div class="pt-2 flex justify-end gap-3">
            <a href="{{ route('library') }}" class="px-4 py-2 bg-neutral-800 rounded-lg text-sm text-white">Batal</a>
            <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-500 rounded-lg text-sm font-semibold">Simpan</button>
        </div>
    </form>
</div>
@endsection
