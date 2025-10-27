<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'driver_service_types')
            ->withPivot('price','id')
            ->withTimestamps();
    }
}
