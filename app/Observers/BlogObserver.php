<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Blog;
use App\Services\ActivityLogger;

class BlogObserver
{
    public function __construct(private readonly ActivityLogger $logger) {}

    public function created(Blog $blog): void
    {
        $this->logger->log(
            ActivityLog::LOG_BLOG,
            'created',
            "Blog post created: {$blog->title}",
            $blog,
            properties: ['published' => $blog->is_published]
        );
    }

    public function updated(Blog $blog): void
    {
        $this->logger->log(
            ActivityLog::LOG_BLOG,
            'updated',
            "Blog post updated: {$blog->title}",
            $blog
        );
    }

    public function deleted(Blog $blog): void
    {
        $this->logger->log(
            ActivityLog::LOG_BLOG,
            'deleted',
            "Blog post deleted: {$blog->title}",
            properties: ['title' => $blog->title]
        );
    }
}
