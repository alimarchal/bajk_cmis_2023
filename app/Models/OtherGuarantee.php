<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherGuarantee extends Model
{
    use HasFactory;

    public $fillable = [
        'primary',
        'secondary',
        'market_value',
        'fsv',
        'ownership',
        'customer_id',
        'remarks',
    ];
}
