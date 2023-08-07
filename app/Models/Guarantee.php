<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'cnic',
        'contact',
        'department_business',
        'business_department_address',
        'guarantor_address',
        'bps',
        'pp_no',
        'customer_id',
    ];

}
