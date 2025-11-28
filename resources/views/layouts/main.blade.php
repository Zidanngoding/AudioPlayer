<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Cloud Music' }}</title>
</head>

<body style="margin:0; padding:0; font-family: Arial; background:#111; color:white;">

    <!-- SIDEBAR -->
    <div style="
        position: fixed;
        left:0;
        top:0;
        width: 150px;
        height: 100vh;
        background:#181818;
        padding:20px;
        border-right:1px solid #333;
    ">
        <h2 style="margin-bottom:30px;">🎵 Music</h2>

        <a href="/" style="color:white; text-decoration:none; display:block; margin-bottom:18px;">Home</a>
        <a href="/library" style="color:white; text-decoration:none; display:block; margin-bottom:18px;">Library</a>
        <a href="/upload" style="color:white; text-decoration:none; display:block; margin-bottom:18px;">Upload</a>
    </div>

    <!-- TOP BAR (selalu ada, tapi bisa kosong) -->
<div style="
    margin-left:220px;
    padding:15px 30px;
    background:#111;
    border-bottom:1px solid #333;
    height:60px; /* menjaga layout tetap rapi */
    display:flex;
    align-items:center;
">
    @if (!request()->routeIs('upload.form'))
        <form action="/search" method="GET" style="width:100%;">
            <input 
                type="text" 
                name="q" 
                placeholder="Search songs, artists..."
                style="
                    width:35%;
                    padding:10px 15px;
                    background:#222;
                    border:1px solid #444;
                    border-radius:30px;
                    color:white;
                ">
        </form>
    @endif
</div>


    <!-- MAIN CONTENT -->
    <div style="margin-left:220px; padding:30px;">
        @yield('content')
    </div>


    
        
        <!-- COVER -->
        <img id="player-cover" src="" class="w-12 h-12 rounded-lg object-cover">

        <!-- TITLE & ARTIST -->
        <div>
            <p id="player-title" class="text-white font-semibold"></p>
            <p id="player-artist" class="text-neutral-400 text-sm"></p>
        </div>

</div>

<script>
function playSong(file, title, artist, cover) {
    document.getElementById('music-player').classList.remove('hidden');

    document.getElementById('audio-control').src = file;
    document.getElementById('audio-control').play();

    document.getElementById('player-title').innerText = title;
    document.getElementById('player-artist').innerText = artist;

    if (cover !== "") {
        document.getElementById('player-cover').src = cover;
    }
}
</script>

<!-- GLOBAL AUDIO PLAYER -->
<audio id="globalPlayer" controls class="fixed bottom-0 left-0 w-full bg-black z-50"></audio>

<script>
const player = document.getElementById("globalPlayer");

function loadSavedState() {
    let src = localStorage.getItem("player_src");
    let time = parseFloat(localStorage.getItem("player_time") || "0");
    let status = localStorage.getItem("player_status");

    if (!src) return;

    player.src = src;
    player.load(); // PENTING: jangan auto-play

    player.onloadedmetadata = () => {
        player.currentTime = time;
        if (status === "playing") {
            player.play(); // baru play setelah currentTime berhasil
        }
    };
}

loadSavedState();

function startSong(path) {
    let full = "/" + path;

    // Simpan data
    localStorage.setItem("player_src", full);
    localStorage.setItem("player_time", "0");
    localStorage.setItem("player_status", "playing");

    // Load dulu, jangan play
    player.src = full;
    player.load();

    player.onloadedmetadata = () => {
        player.currentTime = 0;
        player.play();
    };
}

// SIMPAN POSISI TIAP DETIK
player.addEventListener("timeupdate", () => {
    localStorage.setItem("player_time", player.currentTime);
});

// SIMPAN STATUS
player.addEventListener("play", () => {
    localStorage.setItem("player_status", "playing");
});
player.addEventListener("pause", () => {
    localStorage.setItem("player_status", "paused");
});
</script>



</body>

</html>
