<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueSplit extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'admin_id',
        'payout_id',
        'service_type',
        'total_amount',
        'platform_fee_amount',
        'admin_net_amount',
        'commission_rate_applied',
        'status',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function payout()
    {
        return $this->belongsTo(RevenuePayout::class, 'payout_id');
    }
}
