<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Page;
use App\Services\ActivityLogger;

class PageObserver
{
    public function __construct(private readonly ActivityLogger $logger) {}

    public function created(Page $page): void
    {
        $this->logger->log(
            ActivityLog::LOG_PAGE,
            'created',
            "Page created: {$page->title} (/{$page->slug})",
            $page,
            properties: ['published' => $page->is_published]
        );
    }

    public function updated(Page $page): void
    {
        $this->logger->log(
            ActivityLog::LOG_PAGE,
            'updated',
            "Page updated: {$page->title} (/{$page->slug})",
            $page
        );
    }

    public function deleted(Page $page): void
    {
        $this->logger->log(
            ActivityLog::LOG_PAGE,
            'deleted',
            "Page deleted: {$page->title}",
            properties: ['slug' => $page->slug]
        );
    }
}
