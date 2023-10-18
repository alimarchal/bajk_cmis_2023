<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enhancement extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'enhancement_status',
        'enhancement_amount',
    ];
}
