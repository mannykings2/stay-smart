<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'driver_service_id',
        'price'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function driverService()
    {
        return $this->belongsTo(DriverService::class);
    }

    public function driverBookings()
    {
        return $this->hasMany(DriverBooking::class);
    }
}
