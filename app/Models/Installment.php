<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    public $fillable = [
        'customer_id',
        'user_id',
        'date',
        'principal_amount',
        'mark_up_amount',
        'penalty_charges',
        'insurance_charges',
        'principal_outstanding',
        'total_principal_markup_penalty',
    ];
}
