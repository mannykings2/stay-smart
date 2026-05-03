<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChefBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chef_id',
        'chef_service_type_id',
        'reference',
        'price',
        'booking_id',
        'service_date',
        'service_time',
        'status',
        'number_of_guests',
        'dietary_requirements',
        'menu_notes',
        'booking_base_price',
        'booking_per_unit_price'
    ];

    public function chef()
    {
        return $this->belongsTo(Chef::class);
    }

    public function chefServiceType()
    {
        return $this->belongsTo(ChefServiceType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'chef_booking_id')->latestOfMany();
    }
}
