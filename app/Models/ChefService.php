<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChefService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    public function chefs()
    {
        return $this->belongsToMany(Chef::class, 'chef_service_type')
            ->withPivot('price','id')
            ->withTimestamps();
    }
}
