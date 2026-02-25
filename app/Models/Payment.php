<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'payment_method',
        'amount',
        'trx_ref',
        'status',
    ];

    public function booking(){
        return $this->belongsTo(Booking::class);
    }
}
