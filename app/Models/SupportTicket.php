<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
        'priority',
        'forwarded_to_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forwardedTo()
    {
        return $this->belongsTo(User::class, 'forwarded_to_user_id');
    }

    public function replies()
    {
        return $this->hasMany(SupportReply::class);
    }
}
