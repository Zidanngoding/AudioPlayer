<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Services\AudioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
        $this->hydrateSong($song);

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
            $newCover = $this->audioService->storeCoverFile($request->file('cover'));
            $this->audioService->deletePath($song->cover);
            $song->cover = $newCover;
        }

        if ($request->hasFile('file')) {
            $newSongPath = $this->audioService->storeSongFile($request->file('file'));
            $this->audioService->deletePath($song->file_path);
            $song->file_path = $newSongPath;
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
        $this->audioService->deletePath($song->file_path);
        $this->audioService->deletePath($song->cover);
        $song->delete();

        return redirect()
            ->route('library')
            ->with('success', 'Lagu berhasil dihapus!');
    }

    public function library(): View
    {
        $songs = $this->hydrateSongs(Song::latest()->get());

        if (request()->wantsJson()) {
            return response()->json(['songs' => $songs]);
        }

        return view('pages.library', compact('songs'));
    }

    public function home(): View
    {
        $latest = $this->hydrateSongs(Song::latest()->take(10)->get());

        $topCategory = Song::select('category')
            ->groupBy('category')
            ->orderByRaw('COUNT(*) DESC')
            ->value('category');

        $recommendedRaw = $topCategory
            ? Song::where('category', $topCategory)->latest()->take(10)->get()
            : collect();

        $recommended = $this->hydrateSongs($recommendedRaw);

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

        $songs = $this->hydrateSongs($songs);

        if ($request->wantsJson()) {
            return response()->json([
                'songs' => $songs,
                'query' => $query,
            ]);
        }

        return view('pages.library', compact('songs', 'query'));
    }

    public function playMeta(Request $request, Song $song)
    {
        $payload = $this->playPayload($song);

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json($payload);
        }

        return redirect()->route('library');
    }

    private function hydrateSongs(Collection $songs): Collection
    {
        return $songs->map(fn (Song $song) => $this->hydrateSong($song));
    }

    private function hydrateSong(Song $song): Song
    {
        // Keep stored paths intact; expose URLs separately
        $song->file_url = $this->audioService->url($song->file_path);
        $song->cover_url = $this->audioService->url($song->cover);

        return $song;
    }

    private function playPayload(Song $song): array
    {
        return [
            'id' => $song->id,
            'title' => $song->title,
            'artist' => $song->artist,
            'category' => $song->category,
            'src' => $this->audioService->url($song->file_path),
            'cover' => $this->audioService->url($song->cover),
        ];
    }
}
