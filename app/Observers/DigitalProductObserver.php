<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\DigitalProduct;
use App\Services\ActivityLogger;

class DigitalProductObserver
{
    public function __construct(private readonly ActivityLogger $logger) {}

    public function created(DigitalProduct $product): void
    {
        $this->logger->log(
            ActivityLog::LOG_PRODUCT,
            'created',
            "Product created: {$product->title}",
            $product,
            properties: ['slug' => $product->slug ?? null, 'price' => $product->price]
        );
    }

    public function updated(DigitalProduct $product): void
    {
        $this->logger->log(
            ActivityLog::LOG_PRODUCT,
            'updated',
            "Product updated: {$product->title}",
            $product
        );
    }

    public function deleted(DigitalProduct $product): void
    {
        $this->logger->log(
            ActivityLog::LOG_PRODUCT,
            'deleted',
            "Product deleted: {$product->title}",
            properties: ['title' => $product->title]
        );
    }
}
