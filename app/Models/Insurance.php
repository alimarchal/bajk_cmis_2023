<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'insurance_company',
        'date_of_insurance',
        'insurance_amount',
        'date_of_expiry_of_insurance',
        'remarks',
    ];
}
