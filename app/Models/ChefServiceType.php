<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChefServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'chef_id',
        'chef_service_id',
        'price',
        'base_price',
        'per_unit_price'
    ];

    public function chef()
    {
        return $this->belongsTo(Chef::class);
    }

    public function chefService()
    {
        return $this->belongsTo(ChefService::class);
    }
}
