<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function product_type(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductType::class);
    }
}
