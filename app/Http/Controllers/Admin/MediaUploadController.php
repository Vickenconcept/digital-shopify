<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaUploadController extends Controller
{
    public function __construct(protected FileUploadService $fileUploadService) {}

    /**
     * Handle GrapesJS asset manager image uploads.
     *
     * GrapesJS sends files as multipart/form-data with field name "files[]".
     * Expected JSON response: { "data": ["https://...", ...] }
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'files'   => ['required', 'array'],
            'files.*' => ['required', 'file', 'image', 'max:5120', 'mimes:jpg,jpeg,png,gif,webp,svg'],
        ]);

        $urls = [];

        foreach ($request->file('files', []) as $file) {
            try {
                $urls[] = $this->fileUploadService->uploadFile($file, 'page-builder');
            } catch (\Throwable $e) {
                return response()->json([
                    'errors' => ['Upload failed: ' . $e->getMessage()],
                ], 422);
            }
        }

        // GrapesJS asset manager expects { "data": [ ...urls ] }
        return response()->json(['data' => $urls]);
    }
}
