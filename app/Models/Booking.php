<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'reference',
        'status',
        'check_in_date',
        'check_out_date',
        'check_in_time',
        'check_out_time',
        'total_price',
        'number_of_guests',
    ];

    public function digitalCheckIns()
    {
        return $this->hasMany(DigitalCheckIn::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function chefBookings()
    {
        return $this->hasMany(ChefBooking::class);
    }

    public function rideBookings()
    {
        return $this->hasMany(DriverBooking::class);
    }

    public function isCheckedIn()
    {
        return $this->digitalCheckIns()
            ->where('status', 'Checked In')
            ->exists();
    }
}
