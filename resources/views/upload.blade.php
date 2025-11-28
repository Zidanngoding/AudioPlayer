@extends('layouts.main')

@section('content')

<style>
    /* ==== FORM INPUT STYLING ==== */
    .input-box {
        width: 94%;
        padding: 10px 14px;
        background: #222;
        border: 1px solid #444;
        border-radius: 8px;
        color: white;
        margin-top: 5px;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-purple {
        background: #7d3cff;
        color: white;
    }
    .btn-purple:hover { background: #6c2ee0; }

    .btn-grey {
        background: #444;
        color: white;
    }
    .btn-grey:hover { background: #555; }

    /* ==== MODAL ==== */
    #genreModal {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        display: none;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .modal-box {
        background: #1a1a1a;
        width: 100%;
        max-width: 600px;
        padding: 20px;
        border-radius: 14px;
        border: 1px solid #444;
        color: white;
    }

    .genre-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
        margin-top: 15px;
    }

    .genre-btn {
        padding: 10px;
        background: #333;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        border: 1px solid #444;
    }
    .genre-btn:hover { background: #555; }
</style>


<div style="max-width: 600px; margin: 30px auto; color: white;">

    <h2 style="font-size: 32px; font-weight: bold; margin-bottom: 20px;">
        Upload Lagu Baru
    </h2>

    <div style="background: #111; padding: 20px; border-radius: 12px; border:1px solid #333;">

        <form action="/upload" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Judul Lagu</label>
            <input type="text" name="title" class="input-box" required>

            <label style="margin-top: 15px;">Nama Artis</label>
            <input type="text" name="artist" class="input-box" required>

            <label style="margin-top: 15px;">Genre</label>
            <div style="display:flex; gap:10px;">
                <input type="text" name="category" id="genreInput" class="input-box" style="flex:1;" readonly required>
                <button type="button" onclick="openGenreModal()" class="btn btn-purple">
                    Pilih
                </button>
            </div>

            <label style="margin-top: 15px;">Cover (opsional)</label>
            <input type="file" name="cover" accept="image/*" class="input-box">

            <label style="margin-top: 15px;">File Lagu (MP3)</label>
            <input type="file" name="file" accept=".mp3" class="input-box" required>

            <button type="submit" class="btn btn-purple" style="width: 100%; margin-top: 20px;">
                Upload Lagu
            </button>

        </form>

    </div>
</div>


{{-- ========================= --}}
{{--        GENRE MODAL        --}}
{{-- ========================= --}}
<div id="genreModal">
    <div class="modal-box">

        <div style="display:flex; justify-content:space-between;">
            <h3 style="font-size: 22px; font-weight:bold;">Pilih Genre</h3>
            <button onclick="closeGenreModal()" style="font-size:20px; color:red; background:none; border:none; cursor:pointer;">
                ✕
            </button>
        </div>

        <input type="text" id="genreSearch" placeholder="Cari genre..." class="input-box" onkeyup="filterGenres()">

        <div id="genreGrid" class="genre-grid">
            @foreach($genres as $genre)
                <div class="genre-btn" onclick="selectGenre('{{ $genre }}')">
                    {{ $genre }}
                </div>
            @endforeach
        </div>

        <button class="btn btn-grey" style="width:100%; margin-top:20px;" onclick="closeGenreModal()">
            Tutup
        </button>
    </div>
</div>


{{-- JAVASCRIPT --}}
<script>
    function openGenreModal() {
        document.getElementById('genreModal').style.display = "flex";
    }

    function closeGenreModal() {
        document.getElementById('genreModal').style.display = "none";
    }

    function selectGenre(name) {
        document.getElementById("genreInput").value = name;
        closeGenreModal();
    }

    function filterGenres() {
        let q = document.getElementById("genreSearch").value.toLowerCase();
        let list = document.querySelectorAll(".genre-btn");

        list.forEach(btn => {
            btn.style.display = btn.innerText.toLowerCase().includes(q) ? "block" : "none";
        });
    }
</script>

@endsection
