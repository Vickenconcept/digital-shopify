<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a digital content file.
     *
     * @param UploadedFile $file
     * @param string $type audio|video|ebook
     * @return array
     */
    public function uploadDigitalContent(UploadedFile $file, string $type): array
    {
        $filename = $this->generateUniqueFilename($file);
        $path = $type . '/' . $filename;

        // Store the file in the digital_content disk
        Storage::disk('digital_content')->put($path, file_get_contents($file));

        return [
            'file_path' => $path,
            'file_type' => $type,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'original_filename' => $file->getClientOriginalName(), // Added for download filename
        ];
    }

    /**
     * Upload a thumbnail image.
     *
     * @param UploadedFile $file
     * @return string
     */
    public function uploadThumbnail(UploadedFile $file): string
    {
        $filename = $this->generateUniqueFilename($file);
        $path = 'thumbnails/' . $filename;

        // Store the thumbnail in the public disk
        Storage::disk('public')->put($path, file_get_contents($file));

        return Storage::disk('public')->url($path);
    }

    /**
     * Upload a preview file.
     *
     * @param UploadedFile $file
     * @param string $type audio|video|ebook
     * @return string
     */
    public function uploadPreview(UploadedFile $file, string $type): string
    {
        $filename = $this->generateUniqueFilename($file);
        $path = 'previews/' . $type . '/' . $filename;

        // Store the preview in the public disk
        Storage::disk('public')->put($path, file_get_contents($file));

        return Storage::disk('public')->url($path);
    }

    /**
     * Generate a unique filename.
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function generateUniqueFilename(UploadedFile $file): string
    {
        return Str::uuid() . '.' . $file->getClientOriginalExtension();
    }
}