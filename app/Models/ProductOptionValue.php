<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $fillable = ['product_option_id','option_value_id','price_operator','is_enabled'];

    public function productOption(){
        return $this->belongsTo(ProductOption::class);
    }

    public function prices(){
        return $this->hasMany(ProductOptionValuePrice::class);
    }

    public function images(){
        return $this->hasMany(ProductOptionValueImage::class);
    }
}
