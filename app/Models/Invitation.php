<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'email',
        'inviter_id',
        'role',
        'expires_at',
        'claimed_at',
        'claimed_by'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'claimed_at' => 'datetime',
    ];

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function claimedBy()
    {
        return $this->belongsTo(User::class, 'claimed_by');
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function isClaimed()
    {
        return !is_null($this->claimed_at);
    }

    public function isValid()
    {
        return !$this->isExpired() && !$this->isClaimed();
    }
}
