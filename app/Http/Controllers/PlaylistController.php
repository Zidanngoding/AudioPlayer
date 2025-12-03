<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlaylistController extends Controller
{
    public function index(Request $request): View
    {
        $playlistIds = collect($request->session()->get('playlist', []))->unique()->all();

        $songs = Song::whereIn('id', $playlistIds)
            ->orderByRaw('FIELD(id, ' . implode(',', $playlistIds ?: [0]) . ')')
            ->get();

        return view('pages.playlist', compact('songs'));
    }

    public function store(Request $request, Song $song): RedirectResponse
    {
        $playlist = collect($request->session()->get('playlist', []))
            ->push($song->id)
            ->unique()
            ->values()
            ->all();

        $request->session()->put('playlist', $playlist);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Ditambahkan ke playlist',
                'playlist' => $playlist,
            ]);
        }

        return back()->with('success', 'Ditambahkan ke playlist');
    }

    public function destroy(Request $request, Song $song): RedirectResponse
    {
        $playlist = collect($request->session()->get('playlist', []))
            ->reject(fn ($id) => (int) $id === $song->id)
            ->values()
            ->all();

        $request->session()->put('playlist', $playlist);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Dihapus dari playlist',
                'playlist' => $playlist,
            ]);
        }

        return back()->with('success', 'Dihapus dari playlist');
    }
}
