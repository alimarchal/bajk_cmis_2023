<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Litigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name_of_court',
        'recovery_status',
        'date_of_final_settlement',
    ];
}
