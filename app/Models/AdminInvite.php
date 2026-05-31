<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInvite extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'role', 'token', 'expires_at'];

    /**
     * Check if token is active.
     */
    public function isValid(): bool
    {
        return now()->lt($this->expires_at);
    }
}
