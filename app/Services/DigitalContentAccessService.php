<?php

namespace App\Services;

use App\Models\DigitalProduct;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;

class DigitalContentAccessService
{
    public function userHasPurchased(User $user, DigitalProduct $product): bool
    {
        return $user->orders()
            ->where('payment_status', 'completed')
            ->whereHas('items', fn ($query) => $query->where('digital_product_id', $product->id))
            ->exists();
    }

    public function canDownload(?User $user, DigitalProduct $product): bool
    {
        if (!$product->is_active || !$product->file_path) {
            return false;
        }

        if ($product->is_free) {
            return true;
        }

        return $user && $this->userHasPurchased($user, $product);
    }

    /**
     * Issue a short-lived signed URL that re-checks access before redirecting to the file.
     */
    public function issueDownload(DigitalProduct $product, ?User $user): RedirectResponse
    {
        if (!$product->file_path) {
            abort(404, 'File not found.');
        }

        $signedUrl = URL::temporarySignedRoute(
            'content.deliver',
            now()->addMinutes(30),
            [
                'product' => $product->slug,
                'uid' => $user?->id ?? 0,
            ]
        );

        return redirect($signedUrl);
    }
}
