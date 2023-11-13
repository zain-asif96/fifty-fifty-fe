<?php

namespace App\Models;

use App\Traits\HasAbilities;
use App\Traits\HasRoles;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasAbilities;

    const AUTO_AUTH_METHOD = 'auto';
    const LOGIN_PAGE_AUTH_METHOD = 'login_page';
    const MOBILE_AUTH = 'mobile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'first_name', 'last_name', 'phone', 'email', 'country', 'ip_address', 'transaction_id', 'email_verified_at', 'phone_verified_at', 'auth_method', 'password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['role', 'can_access_admin'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public static function getUserFromSession()
    {
        return session('current_user_' . request()->ip());
    }

    public static function putUserIntoSession($user)
    {
        session()->put(['current_user_' . request()->ip() => $user]);
    }
    // public static function getReceiverFromSession()
    // {
    //     return session('current_receiver_' . request()->ip());
    // }

    // public static function putReceiverIntoSession($user)
    // {
    //     session()->put(['current_receiver_' . request()->ip() => $user]);
    // }
    // Attributes
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first()?->name;
    }

    public function getCanAccessAdminAttribute(): bool
    {
        return $this->hasAnyRole(['super.admin', 'admin', 'manager']);
    }

    public function getEmailVerifiedAtAttribute($verifiedAt)
    {
        $now = Carbon::now();

        if ($now->diffInMinutes($verifiedAt) > env('SESSION_LIFETIME')) {
            return null;
        }

        return $verifiedAt;
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::create($created_at)->toFormattedDateString();
    }

    public function getPhoneVerifiedAtAttribute($verifiedAt)
    {
        $now = Carbon::now();

        if ($now->diffInMinutes($verifiedAt) > env('SESSION_LIFETIME')) {
            return null;
        }

        return $verifiedAt;
    }

    // helpers:
    public function handlingTransaction(): bool
    {
        return !!$this->transaction_id;
    }

    public function getHandledTransaction(): Model|null
    {
        return Transaction::with('user:id,country')
            ->where('id', $this->transaction_id)
            ->first();
    }

    /* Relations */
    public function receivers(): HasMany
    {
        return $this->hasMany(Receiver::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function paymentIntents(): HasMany
    {
        return $this->hasMany(PaymentIntent::class);
    }

    // Twilio to phone number
    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }

    // User Mobile Devices
    public function mobileDevices(): HasMany
    {
        return $this->hasMany(MobileDevice::class);
    }
}
