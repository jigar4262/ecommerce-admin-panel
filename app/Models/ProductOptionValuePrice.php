<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValuePrice extends Model
{
    protected $fillable = ['product_option_value_id', 'currency', 'price'];

    public function optionValue() {
        return $this->belongsTo(ProductOptionValue::class, 'product_option_value_id');
    }
}
