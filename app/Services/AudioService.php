<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AudioService
{
    private const SONG_FOLDER = 'songs';
    private const COVER_FOLDER = 'covers';

    public function storeSongFile(UploadedFile $file): string
    {
        return $this->storeFile($file, self::SONG_FOLDER);
    }

    public function storeCoverFile(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        return $this->storeFile($file, self::COVER_FOLDER);
    }

    public function deletePath(?string $path): void
    {
        if (!$path) {
            return;
        }

        $disk = $this->disk();

        if ($disk->exists($path)) {
            $disk->delete($path);
        }
    }

    public function url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return $this->disk()->url($path);
    }

    private function storeFile(UploadedFile $file, string $folder): string
    {
        $filename = uniqid() . '_' . $file->getClientOriginalName();

        return $this->disk()->putFileAs($folder, $file, $filename);
    }

    private function disk()
    {
        return Storage::disk('oci');
    }
}
