@props(['song'])

<div class="w-40">
    <div class="w-40 h-40 rounded-xl overflow-hidden bg-neutral-800">
        <img src="/{{ $song->cover ?? 'defaultcover.jpg' }}"
             class="w-full h-full object-cover">
    </div>

    <p class="text-white font-semibold mt-2 truncate">{{ $song->title }}</p>
    <p class="text-neutral-400 text-sm truncate">Song • {{ $song->artist }}</p>
</div>

