<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'log_name',
        'event',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    public const LOG_AUTH = 'auth';
    public const LOG_ORDER = 'order';
    public const LOG_PAYMENT = 'payment';
    public const LOG_CONTACT = 'contact';
    public const LOG_EMAIL = 'email';
    public const LOG_PRODUCT = 'product';
    public const LOG_CATEGORY = 'category';
    public const LOG_BLOG = 'blog';
    public const LOG_PAGE = 'page';
    public const LOG_USER = 'user';
    public const LOG_SETTINGS = 'settings';
    public const LOG_ADMIN = 'admin';

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    public function getLogLabelAttribute(): string
    {
        return match ($this->log_name) {
            self::LOG_AUTH => 'Authentication',
            self::LOG_ORDER => 'Orders',
            self::LOG_PAYMENT => 'Payments',
            self::LOG_CONTACT => 'Contact',
            self::LOG_EMAIL => 'Email',
            self::LOG_PRODUCT => 'Products',
            self::LOG_CATEGORY => 'Categories',
            self::LOG_BLOG => 'Blog',
            self::LOG_PAGE => 'Pages',
            self::LOG_USER => 'Users',
            self::LOG_SETTINGS => 'Settings',
            self::LOG_ADMIN => 'Admin',
            default => ucfirst($this->log_name),
        };
    }

    public function getBadgeColorAttribute(): string
    {
        return match ($this->log_name) {
            self::LOG_AUTH => 'blue',
            self::LOG_ORDER, self::LOG_PAYMENT => 'green',
            self::LOG_CONTACT => 'purple',
            self::LOG_EMAIL => 'indigo',
            self::LOG_PRODUCT, self::LOG_CATEGORY, self::LOG_BLOG, self::LOG_PAGE => 'orange',
            self::LOG_USER => 'pink',
            self::LOG_SETTINGS => 'gray',
            self::LOG_ADMIN => 'red',
            default => 'gray',
        };
    }
}
