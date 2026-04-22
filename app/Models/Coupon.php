<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'coupon_code',
        'discount_type',
        'discount_value',
        'max_discount',
        'min_order_amt',
        'per_user_limit',
        'total_usage_limit',
        'start_date',
        'end_date',
        'is_login_required',
        'apply_coupon_on',
        'description',
        'status','created_by'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class,'coupon_category');
    }   

    public function products(){
        return $this->belongsToMany(Product::class,'coupon_product'); 
    }
}
