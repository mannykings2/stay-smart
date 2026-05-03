<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenuePayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'amount',
        'reference',
        'status',
        'payment_method',
        'payment_reference',
        'paid_at',
        'notes',
        'receipt_image',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function splits()
    {
        return $this->hasMany(RevenueSplit::class, 'payout_id');
    }
}
