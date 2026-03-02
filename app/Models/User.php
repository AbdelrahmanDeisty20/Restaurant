<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone',
        'avatar',
        'is_active',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'avatar',
    ];

    protected $appends = [
        'avatar_path',
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
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderReviews()
    {
        return $this->hasMany(OrderReview::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function getAvatarPathAttribute($value)
    {
        return asset('storage/users/avatars/' . $value);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function driverReviews()
    {
        return $this->hasMany(DriverReview::class);
    }

    public function refreshTokens()
    {
        return $this->hasMany(RefreshToken::class);
    }

    public function fcmTokens()
    {
        return $this->hasMany(UserFcmToken::class);
    }

    public function appNotifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function getNameAttribute()
    {
        return $this->full_name;
    }
}
