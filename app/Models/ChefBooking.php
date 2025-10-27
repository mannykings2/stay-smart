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
        'price',
        'booking_id',
        'service_date',
        'service_time',
        'status'];

    public function chef()
    {
        return $this->belongsTo(Chef::class);
    }

    public function chefServiceType()
    {
        return $this->belongsTo(ChefServiceType::class);
    }
}
