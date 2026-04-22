<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $fillable=['product_id','qty','sort_order'];    

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function prices(){
        return $this->hasMany(ProductDiscountPrice::class);
    }
}
