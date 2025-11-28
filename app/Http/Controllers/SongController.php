<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

class SongController extends Controller
{
    /* ===========================
     *  FORM UPLOAD
     * =========================== */
    public function uploadForm()
    {
        $genres = config('genres'); // ambil list genre
        return view('upload', compact('genres'));
    }


    /* ===========================
     *  UPLOAD LAGU BARU
     * =========================== */
    public function upload(Request $request)
    {
        $request->validate([
            'title'    => 'required',
            'artist'   => 'required',
            'category' => 'required',
            'file'     => 'required|mimes:mp3|max:20000',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Pastikan folder ada
        if (!file_exists(public_path('songs'))) {
            mkdir(public_path('songs'), 0777, true);
        }
        if (!file_exists(public_path('covers'))) {
            mkdir(public_path('covers'), 0777, true);
        }

        // FILE MP3
        $file = $request->file('file');
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $file->move(public_path('songs'), $fileName);

        // COVER (opsional)
        $coverName = null;
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = uniqid() . '_cover_' . $cover->getClientOriginalName();
            $cover->move(public_path('covers'), $coverName);
        }

        // SIMPAN DATABASE
        Song::create([
            'title'     => $request->title,
            'artist'    => $request->artist,
            'category'  => $request->category,
            'file_path' => 'songs/' . $fileName,
            'cover'     => $coverName ? 'covers/' . $coverName : null,
            'uploader'  => 'User'
        ]);

        return redirect('/library');
    }


    /* ===========================
     *  HALAMAN EDIT
     * =========================== */
    public function edit($id)
    {
        $song = Song::findOrFail($id);
        $genres = config('genres');

        return view('edit', compact('song', 'genres'));
    }


    /* ===========================
     *  UPDATE LAGU
     * =========================== */
    public function update(Request $request, $id)
    {
        $song = Song::findOrFail($id);

        $request->validate([
            'title'    => 'required',
            'artist'   => 'required',
            'category' => 'required',
            'file'     => 'nullable|mimes:mp3|max:20000',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // UPDATE COVER
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = uniqid() . '_cover_' . $cover->getClientOriginalName();
            $cover->move(public_path('covers'), $coverName);
            $song->cover = 'covers/' . $coverName;
        }

        // UPDATE FILE MP3
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('songs'), $fileName);
            $song->file_path = 'songs/' . $fileName;
        }

        // UPDATE FIELD
        $song->title    = $request->title;
        $song->artist   = $request->artist;
        $song->category = $request->category;
        $song->save();

        return redirect('/library')->with('success', 'Lagu berhasil diupdate!');
    }


    /* ===========================
     *  DELETE LAGU
     * =========================== */
    public function destroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();

        return redirect('/library')->with('success', 'Lagu berhasil dihapus!');
    }


    /* ===========================
     *  LIBRARY
     * =========================== */
    public function library()
    {
        $songs = Song::latest()->get();
        return view('library', compact('songs'));
    }


    /* ===========================
     *  HOME (Listen Again + Recommended)
     * =========================== */
    public function home()
    {
        // listen again (10 terbaru)
        $latest = Song::latest()->take(10)->get();

        // kategori terbanyak
        $topCategory = Song::select('category')
            ->groupBy('category')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->value('category');

        // rekomendasi
        $recommended = Song::where('category', $topCategory)
                            ->inRandomOrder()
                            ->take(10)
                            ->get();

        return view('home', compact('latest', 'recommended', 'topCategory'));
    }


    /* ===========================
     *  SEARCH
     * =========================== */
    public function search(Request $request)
    {
        $q = $request->q;

        $songs = Song::where('title', 'LIKE', "%$q%")
                    ->orWhere('artist', 'LIKE', "%$q%")
                    ->orWhere('category', 'LIKE', "%$q%")
                    ->get();

        return view('library', compact('songs'));
    }
}
