<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWiseNplMonthly extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id','product_id','product_type_id','no_of_accounts','principle_outstanding'];
}
