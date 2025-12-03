<div id="player-shell" data-turbo-permanent class="fixed inset-x-0 bottom-0 bg-neutral-900 border-t border-neutral-800 shadow-xl">
    <div class="flex items-center gap-4 px-6 py-3">
        <div class="flex items-center gap-3 w-1/3 min-w-[240px]">
            <div class="w-14 h-14 rounded-lg overflow-hidden bg-neutral-800 shrink-0">
                <img id="player-cover" src="" alt="cover" class="w-full h-full object-cover hidden">
                <div id="player-placeholder" class="w-full h-full bg-gradient-to-br from-neutral-700 to-neutral-900"></div>
            </div>
            <div>
                <p id="player-title" class="font-semibold text-white text-sm">Nothing playing</p>
                <p id="player-artist" class="text-neutral-400 text-xs">Select a song</p>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center gap-2 w-1/3">
            <div class="flex items-center gap-3">
                <button type="button" data-player-action="prev" class="px-3 py-2 bg-neutral-800 rounded-md text-xs text-neutral-200">Prev</button>
                <button type="button" data-player-action="toggle" class="px-4 py-2 bg-purple-600 hover:bg-purple-500 rounded-md text-sm font-semibold">Play</button>
                <button type="button" data-player-action="next" class="px-3 py-2 bg-neutral-800 rounded-md text-xs text-neutral-200">Next</button>
            </div>
            <div class="flex items-center gap-2 w-full">
                <span id="player-time" class="text-xs text-neutral-400 w-12 text-right">0:00</span>
                <input id="player-seek" type="range" min="0" max="100" value="0" class="w-full accent-purple-500">
                <span id="player-duration" class="text-xs text-neutral-400 w-12">0:00</span>
            </div>
        </div>

        <div class="flex items-center gap-3 w-1/3 justify-end">
            <button type="button" id="player-mute" class="px-3 py-2 bg-neutral-800 rounded-md text-xs text-neutral-200">Mute</button>
            <input id="player-volume" type="range" min="0" max="1" step="0.01" value="1" class="w-24 accent-purple-500">
        </div>
    </div>

    <audio id="global-player" data-turbo-permanent class="hidden"></audio>
</div>
