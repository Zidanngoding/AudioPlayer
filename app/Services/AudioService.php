<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class AudioService
{
    private const SONG_DIR = 'songs';
    private const COVER_DIR = 'covers';

    public function storeSongFile(UploadedFile $file): string
    {
        $this->ensureDirectory(self::SONG_DIR);

        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $file->move(public_path(self::SONG_DIR), $fileName);

        return self::SONG_DIR . '/' . $fileName;
    }

    public function storeCoverFile(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        $this->ensureDirectory(self::COVER_DIR);

        $fileName = uniqid() . '_cover_' . $file->getClientOriginalName();
        $file->move(public_path(self::COVER_DIR), $fileName);

        return self::COVER_DIR . '/' . $fileName;
    }

    private function ensureDirectory(string $folder): void
    {
        $path = public_path($folder);

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }
}
