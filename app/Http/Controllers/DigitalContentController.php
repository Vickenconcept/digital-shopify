<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Services\DigitalContentAccessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DigitalContentController extends Controller
{
    public function __construct(
        private readonly DigitalContentAccessService $access,
    ) {}

    public function download(DigitalProduct $product): RedirectResponse
    {
        return $this->serve($product);
    }

    public function stream(DigitalProduct $product): RedirectResponse
    {
        return $this->serve($product);
    }

    /**
     * Signed delivery endpoint — re-validates purchase before redirecting to the file URL.
     */
    public function deliver(Request $request, DigitalProduct $product): RedirectResponse
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'This download link has expired. Please request a new download from your library.');
        }

        if (!$product->is_active || !$product->file_path) {
            abort(404, 'File not found.');
        }

        $user = auth()->user();
        $signedUserId = (int) $request->query('uid', 0);

        if ($product->is_free) {
            return redirect($product->file_path);
        }

        if (!$user || $user->id !== $signedUserId) {
            abort(403, 'Invalid download session.');
        }

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if (!$this->access->userHasPurchased($user, $product)) {
            abort(403, 'You have not purchased this product.');
        }

        return redirect($product->file_path);
    }

    private function serve(DigitalProduct $product): RedirectResponse
    {
        if (!$product->is_active) {
            abort(404);
        }

        $user = auth()->user();

        if ($product->is_free) {
            return $this->access->issueDownload($product, $user);
        }

        if (!$user) {
            return redirect()
                ->route('login')
                ->with('error', 'Please sign in to access purchased content.');
        }

        if (!$user->hasVerifiedEmail()) {
            return redirect()
                ->route('verification.notice')
                ->with('error', 'Please verify your email before downloading purchases.');
        }

        if (!$this->access->userHasPurchased($user, $product)) {
            abort(403, 'You have not purchased this product.');
        }

        return $this->access->issueDownload($product, $user);
    }
}
