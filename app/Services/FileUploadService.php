<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    protected Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary();
    }

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
        
        // Upload to Cloudinary
        $cloudinaryResponse = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
            'resource_type' => $this->getResourceType($file),
            'folder' => "digital_content/{$type}",
            'public_id' => pathinfo($filename, PATHINFO_FILENAME),
            'use_filename' => false,
            'unique_filename' => true,
        ]);

        return [
            'file_path' => $cloudinaryResponse['secure_url'],
            'file_type' => $type,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'original_filename' => $file->getClientOriginalName(),
            'cloudinary_public_id' => $cloudinaryResponse['public_id'],
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
        
        // Upload to Cloudinary
        $cloudinaryResponse = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
            'resource_type' => 'image',
            'folder' => 'thumbnails',
            'public_id' => pathinfo($filename, PATHINFO_FILENAME),
            'use_filename' => false,
            'unique_filename' => true,
        ]);

        return $cloudinaryResponse['secure_url'];
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
        
        // Upload to Cloudinary
        $cloudinaryResponse = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
            'resource_type' => $this->getResourceType($file),
            'folder' => "previews/{$type}",
            'public_id' => pathinfo($filename, PATHINFO_FILENAME),
            'use_filename' => false,
            'unique_filename' => true,
        ]);

        return $cloudinaryResponse['secure_url'];
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

    /**
     * Get Cloudinary resource type based on file extension.
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function getResourceType(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Image files
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'tiff', 'psd'])) {
            return 'image';
        }
        
        // Video files
        if (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv', '3gp'])) {
            return 'video';
        }
        
        // Audio files
        if (in_array($extension, ['mp3', 'wav', 'flac', 'aac', 'ogg', 'wma', 'm4a'])) {
            return 'video'; // Cloudinary uses 'video' for audio files
        }
        
        // Raw files (documents, etc.)
        if (in_array($extension, ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt', 'xls', 'xlsx', 'ppt', 'pptx'])) {
            return 'raw';
        }
        
        // Default to raw for unknown types
        return 'raw';
    }

    /**
     * Upload any file to Cloudinary with custom folder.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     */
    public function uploadFile(UploadedFile $file, string $folder = 'uploads'): string
    {
        $filename = $this->generateUniqueFilename($file);
        
        // Upload to Cloudinary
        $cloudinaryResponse = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
            'resource_type' => $this->getResourceType($file),
            'folder' => $folder,
            'public_id' => pathinfo($filename, PATHINFO_FILENAME),
            'use_filename' => false,
            'unique_filename' => true,
        ]);

        return $cloudinaryResponse['secure_url'];
    }
}