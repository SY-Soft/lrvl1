<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsImageService
{
    public function saveUploaded($file)
    {
        $originalName = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        $extension = $file->getClientOriginalExtension();

        return $this->storeFile(
            $file->get(),
            $originalName,
            $extension
        );
    }

    public function saveFromPath($path)
    {
        $originalName = pathinfo(
            basename($path),
            PATHINFO_FILENAME
        );

        $extension = pathinfo(
            basename($path),
            PATHINFO_EXTENSION
        );

        return $this->storeFile(
            file_get_contents($path),
            $originalName,
            $extension
        );
    }

    private function storeFile($content, $originalName, $extension)
    {
        $baseName = Str::slug($originalName);

        if (!$baseName) {
            $baseName = 'image';
        }

        $fileName = $baseName . '.' . $extension;
        $counter = 1;

        while (
        Storage::disk('public')->exists(
            'images/news/' . $fileName
        )
        ) {
            $fileName = $baseName . '_' . $counter . '.' . $extension;
            $counter++;
        }

        Storage::disk('public')->put(
            'images/news/' . $fileName,
            $content
        );

        return 'images/news/' . $fileName;
    }
}
