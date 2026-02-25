<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalCheckIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'check_in_time',
        'check_out_time',
        'status'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
