<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Enhancement extends Model
{
    use HasFactory;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }

    protected $fillable = [
        'customer_id',
        'enhancement_status',
        'enhancement_amount',
    ];
}
