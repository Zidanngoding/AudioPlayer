@extends('layouts.main')

@section('content')

<style>
    .scroll-x {
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .scroll-item {
        display: inline-block;
        vertical-align: top;
        margin-right: 24px;
    }
</style>

<div class="p-8 text-white">

    <!-- LISTEN AGAIN -->
    <h2 class="text-3xl font-bold mb-4">Listen Again</h2>

    <div class="scroll-x pb-4">
        @foreach ($latest as $song)
            <div onclick="playSong('{{ $song->file_path }}')" class="scroll-item w-[96px] cursor-pointer">
                <div class="w-[96px] h-[96px] rounded-lg overflow-hidden bg-neutral-800">
                    <img src="/{{ $song->cover ?? 'defaultcover.jpg' }}" 
                         class="w-full h-full object-cover">
                </div>

                <p class="mt-2 font-semibold text-sm truncate">{{ $song->title }}</p>
                <p class="text-neutral-400 text-xs truncate">Song • {{ $song->artist }}</p>
            </div>
        @endforeach
    </div>


    <!-- RECOMMENDED -->
    <h2 class="text-3xl font-bold mt-10 mb-4">
        Recommended • {{ ucfirst($topCategory) }}
    </h2>

    <div class="scroll-x pb-4">
        @foreach ($recommended as $song)
            <div onclick="playSong('{{ $song->file_path }}')" class="scroll-item w-[96px] cursor-pointer">
                <div class="w-[96px] h-[96px] rounded-lg overflow-hidden bg-neutral-800">
                    <img src="/{{ $song->cover ?? 'defaultcover.jpg' }}" 
                         class="w-full h-full object-cover">
                </div>

                <p class="mt-2 font-semibold text-sm truncate">{{ $song->title }}</p>
                <p class="text-neutral-400 text-xs truncate">Song • {{ $song->artist }}</p>
            </div>
        @endforeach
    </div>

</div>

@endsection
