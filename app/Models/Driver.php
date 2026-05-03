<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'specialty',
        'phone_number',
        'vehicle_details',
        'license_number',
        'availability_status',
        'image',
        'max_occupants',
        'hourly_rate',
        'extra_person_charge'
    ];

    public function driverServices()
    {
        return $this->belongsToMany(DriverService::class, 'driver_service_types')
            ->withPivot('price', 'id')
            ->withTimestamps();
    }

    public function driverBookings()
    {
        return $this->hasMany(DriverBooking::class);
    }
}
