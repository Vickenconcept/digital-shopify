<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use Illuminate\Http\RedirectResponse;

class DigitalContentController extends Controller
{
    public function download(DigitalProduct $product): RedirectResponse
    {
        // Check if the product is free
        if (!$product->is_free) {
            abort(403, 'This content requires purchase.');
        }

        // Check if file path exists (Cloudinary URL)
        if (!$product->file_path) {
            abort(404, 'File not found.');
        }

        // Redirect to Cloudinary URL for download
        return redirect($product->file_path);
    }
}