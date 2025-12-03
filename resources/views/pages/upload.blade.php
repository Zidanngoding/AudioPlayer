@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h2 class="text-3xl font-bold">Upload Lagu Baru</h2>
        <p class="text-neutral-400 text-sm mt-1">Lengkapi detail lagu dan unggah file MP3.</p>
    </div>

    <form action="{{ route('upload.song') }}" method="POST" enctype="multipart/form-data" data-turbo="false" class="bg-neutral-900/60 border border-neutral-800 rounded-xl p-6 space-y-4">
        @csrf

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">Judul Lagu</label>
            <input type="text" name="title" class="w-full bg-neutral-950 border border-neutral-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500" required>
        </div>

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">Nama Artis</label>
            <input type="text" name="artist" class="w-full bg-neutral-950 border border-neutral-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500" required>
        </div>

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">Genre</label>
            <select name="category" class="w-full bg-neutral-950 border border-neutral-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500" required>
                <option value="">Pilih genre</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre }}">{{ $genre }}</option>
                @endforeach
            </select>
        </div>

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">Cover (opsional)</label>
            <input type="file" name="cover" accept="image/*" class="w-full text-sm text-neutral-400">
        </div>

        <div class="space-y-2">
            <label class="text-sm text-neutral-300">File Lagu (MP3)</label>
            <input type="file" name="file" accept=".mp3" class="w-full text-sm text-neutral-400" required>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-500 rounded-lg text-sm font-semibold">Upload</button>
        </div>
    </form>
</div>
@endsection
