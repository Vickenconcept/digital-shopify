<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DigitalContentController extends Controller
{
    public function download(DigitalProduct $product): StreamedResponse
    {
        // Check if the product is free
        if (!$product->is_free) {
            abort(403, 'This content requires purchase.');
        }

        // Get the file path from the product
        $filePath = $product->file_path;

        // Check if file exists
        if (!Storage::disk('digital_content')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        // Get the original file name or use a default one based on file type
        $originalName = $product->original_name ?? 'download.' . pathinfo($filePath, PATHINFO_EXTENSION);

        // Stream the file as a download
        return Storage::disk('digital_content')->download($filePath, $originalName);
    }
}