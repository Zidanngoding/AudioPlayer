<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Services\AudioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SongController extends Controller
{
    public function __construct(
        private readonly AudioService $audioService
    ) {
    }

    public function uploadForm(): View
    {
        $genres = config('genres');

        return view('pages.upload', compact('genres'));
    }

    public function upload(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'artist' => ['required', 'string'],
            'category' => ['required', 'string'],
            'file' => ['required', 'mimes:mp3', 'max:20000'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $filePath = $this->audioService->storeSongFile($request->file('file'));
        $coverPath = $this->audioService->storeCoverFile($request->file('cover'));

        Song::create([
            'title' => $validated['title'],
            'artist' => $validated['artist'],
            'category' => $validated['category'],
            'file_path' => $filePath,
            'cover' => $coverPath,
            'uploader' => 'User',
        ]);

        return redirect()->route('library');
    }

    public function edit(Song $song): View
    {
        $genres = config('genres');

        return view('pages.edit', compact('song', 'genres'));
    }

    public function update(Request $request, Song $song): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'artist' => ['required', 'string'],
            'category' => ['required', 'string'],
            'file' => ['nullable', 'mimes:mp3', 'max:20000'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            $song->cover = $this->audioService->storeCoverFile($request->file('cover'));
        }

        if ($request->hasFile('file')) {
            $song->file_path = $this->audioService->storeSongFile($request->file('file'));
        }

        $song->fill([
            'title' => $validated['title'],
            'artist' => $validated['artist'],
            'category' => $validated['category'],
        ])->save();

        return redirect()
            ->route('library')
            ->with('success', 'Lagu berhasil diupdate!');
    }

    public function destroy(Song $song): RedirectResponse
    {
        $song->delete();

        return redirect()
            ->route('library')
            ->with('success', 'Lagu berhasil dihapus!');
    }

    public function playMeta(Request $request, Song $song)
    {
        $payload = [
            'id' => $song->id,
            'title' => $song->title,
            'artist' => $song->artist,
            'category' => $song->category,
            'src' => asset($song->file_path),
            'cover' => $song->cover ? asset($song->cover) : null,
        ];

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json($payload);
        }

        return redirect()->route('library');
    }

    public function library(): View
    {
        $songs = Song::latest()->get();

        if (request()->wantsJson()) {
            return response()->json([
                'songs' => $songs,
            ]);
        }

        return view('pages.library', compact('songs'));
    }

    public function home(): View
    {
        $latest = Song::latest()->take(10)->get();

        $topCategory = Song::select('category')
            ->groupBy('category')
            ->orderByRaw('COUNT(*) DESC')
            ->value('category');

        $recommended = $topCategory
            ? Song::where('category', $topCategory)
                ->latest()
                ->take(10)
                ->get()
            : collect();

        if (request()->wantsJson()) {
            return response()->json([
                'latest' => $latest,
                'recommended' => $recommended,
                'topCategory' => $topCategory,
            ]);
        }

        return view('pages.home', compact('latest', 'recommended', 'topCategory'));
    }

    public function search(Request $request): View
    {
        $query = $request->string('q')->toString();

        $songs = Song::query()
            ->when($query, function ($builder) use ($query) {
                $builder
                    ->where('title', 'like', "%{$query}%")
                    ->orWhere('artist', 'like', "%{$query}%")
                    ->orWhere('category', 'like', "%{$query}%");
            })
            ->latest()
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'songs' => $songs,
                'query' => $query,
            ]);
        }

        return view('pages.library', compact('songs', 'query'));
    }
}
