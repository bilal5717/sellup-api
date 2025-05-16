<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'otp',
        'created_at',
        'verified_at',
        'is_used'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_used' => 'boolean'
    ];
    public static function findValidOtp(string $email, string $otp)
    {
        return static::where('email', $email)
            ->where('otp', $otp)
            ->where('created_at', '>=', now()->subMinutes(0.5)) // OTP valid for 15 mins
            ->where('is_used', false)
            ->first();
    }
}
