@extends('layouts.main')

@section('content')
<div class="space-y-10">
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Listen Again</h2>
            <button type="button" class="text-sm text-purple-400 hover:text-purple-300 js-queue" data-target="listen-again">Play all</button>
        </div>
        <div class="flex gap-4 overflow-x-auto pb-3" data-tracklist="listen-again">
            @foreach ($latest as $song)
                <x-song-card :song="$song" />
            @endforeach
        </div>
    </section>

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Recommended {{ $topCategory ? '— ' . ucfirst($topCategory) : '' }}</h2>
            <button type="button" class="text-sm text-purple-400 hover:text-purple-300 js-queue" data-target="recommended">Play all</button>
        </div>
        <div class="flex gap-4 overflow-x-auto pb-3" data-tracklist="recommended">
            @forelse ($recommended as $song)
                <x-song-card :song="$song" />
            @empty
                <p class="text-neutral-400 text-sm">Belum ada rekomendasi.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
