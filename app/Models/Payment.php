<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'chef_booking_id',
        'ride_booking_id',
        'user_id',
        'payment_method',
        'amount',
        'trx_ref',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chefBooking()
    {
        return $this->belongsTo(ChefBooking::class);
    }

    public function rideBooking()
    {
        return $this->belongsTo(DriverBooking::class, 'ride_booking_id');
    }

    public function revenueSplit()
    {
        return $this->hasOne(RevenueSplit::class);
    }
}
