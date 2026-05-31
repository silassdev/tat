<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailOtp extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'otp', 'expires_at', 'verified'];

    /**
     * Check if OTP has expired.
     */
    public function isExpired(): bool
    {
        return now()->gt($this->expires_at);
    }
}
