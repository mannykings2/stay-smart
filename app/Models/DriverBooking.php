<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverBooking extends Model
{
    use HasFactory;

    protected $table = 'ride_bookings';

    protected $fillable = [
        'user_id',
        'driver_id',
        'driver_service_type_id',
        'price',
        'reference',
        'booking_id',
        'ride_date',
        'ride_time',
        'pickup_location',
        'dropoff_location',
        'status'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function driverServiceType()
    {
        return $this->belongsTo(DriverServiceType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
