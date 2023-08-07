<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkUpDetails extends Model
{
    use HasFactory;

    public $fillable = [
        'customer_id',
        'date',
        'markup_receivable_4600',
        'markup_recovered_till_date',
        'markup_recovered_ac_5008',
        'markup_recovered_ac_2405',
    ];
}
