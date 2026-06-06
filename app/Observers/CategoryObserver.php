<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Services\ActivityLogger;

class CategoryObserver
{
    public function __construct(private readonly ActivityLogger $logger) {}

    public function created(Category $category): void
    {
        $this->logger->log(
            ActivityLog::LOG_CATEGORY,
            'created',
            "Category created: {$category->name}",
            $category
        );
    }

    public function updated(Category $category): void
    {
        $this->logger->log(
            ActivityLog::LOG_CATEGORY,
            'updated',
            "Category updated: {$category->name}",
            $category
        );
    }

    public function deleted(Category $category): void
    {
        $this->logger->log(
            ActivityLog::LOG_CATEGORY,
            'deleted',
            "Category deleted: {$category->name}",
            properties: ['name' => $category->name]
        );
    }
}
