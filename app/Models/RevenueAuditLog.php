<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueAuditLog extends Model
{
    protected $fillable = [
        'changed_by',
        'entity_type',
        'entity_id',
        'field_changed',
        'old_value',
        'new_value',
    ];

    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
