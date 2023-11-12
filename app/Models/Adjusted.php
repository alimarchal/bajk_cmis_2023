<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Adjusted extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = [
        'user_id',
        'customer_id',
        'adjusted_status',
        'name', 'text'
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }
}
