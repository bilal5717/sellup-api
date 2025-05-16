<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_phone',
        'password',
        'username',
        'facebook_id',
        'google_id',
        'phone_id',
        'user_address',
        'user_about_me',
        'role_id',
        'code',
        'otp_sent_at',
'phone_verified_at',
        'over_all_ratting',
        'is_show_email',
        'is_show_phone',
        'is_vendor',
        'user_location',
        'password_reset_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_sent_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'is_vendor' => 'boolean',
        'is_show_email' => 'boolean',
        'is_show_phone' => 'boolean',
        'user_is_system_admin' => 'boolean',
        'over_all_ratting' => 'float',
        'password' => 'hashed', // Laravel 10+
    ];
}
