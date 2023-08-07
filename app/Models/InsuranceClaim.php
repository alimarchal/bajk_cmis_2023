<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'insurance_id',
        'claim_amount',
        'date_of_claim',
        'remarks',
        'status',
    ];
}
