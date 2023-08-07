<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valuation extends Model
{
    use HasFactory;

    public $fillable = [
        'customer_id',
        'evaluator_company',
        'date_of_valuation',
        'date_of_valuation_expiry',
    ];
}
