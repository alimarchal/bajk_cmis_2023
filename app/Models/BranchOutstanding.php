<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchOutstanding extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'principle_outstanding'
    ];
}
