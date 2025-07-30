<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'twitter_account_connected',
        'twitter_account_id',
        'twitter_access_token',
        'twitter_access_token_secret',
        'twitter_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'twitter_account_connected' => 'boolean',
        ];
    }

    public function isTwitterConnected()
    {
        return $this->twitter_account_connected && $this->twitter_account_id && $this->twitter_access_token;
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function digitalProducts()
    {
        return $this->hasMany(DigitalProduct::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function purchasedProducts()
    {
        return $this->hasManyThrough(
            DigitalProduct::class,
            OrderItem::class,
            'order_id',
            'id',
            'id',
            'digital_product_id'
        )->whereHas('order', function ($query) {
            $query->where('payment_status', 'completed');
        });
    }
}
