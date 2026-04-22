<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValueImage extends Model
{
    protected $fillable = ['product_option_value_id', 'image_url'];

    public function optionValue()
    {
        return $this->belongsTo(ProductOptionValue::class, 'product_option_value_id');
    }
}
