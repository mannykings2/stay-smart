<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRevenueConfig extends Model
{
    protected $fillable = [
        'user_id',
        'commission_rate',
        'staff_commission_rate',
        'payout_frequency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
