<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'specialty',
        'phone_number',
        'availability_status',
        'image',
    ];

    public function chefServices()
    {
        return $this->belongsToMany(ChefService::class, 'chef_service_types')
            ->withPivot('price','id')
            ->withTimestamps();
    }
}
