<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDiscountPrice extends Model
{
    protected $fillable = ['product_id', 'discount_id', 'currency', 'price'];

    public function discount() {
        return $this->belongsTo(ProductDiscount::class, 'discount_id');
    }
}
