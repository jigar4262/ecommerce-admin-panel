<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'stock_qty','sku','slug','min_qty','max_qty','main_image'];

    public function categories(){
        return $this->belongsToMany(Category::class,'product_categories');
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class);
    }

    public function discounts(){
        return $this->hasMany(ProductDiscount::class);
    }

    public function options(){
        return $this->hasMany(ProductOption::class);
    }

    public function setNameAttribute($value){
        
        $this->attributes['name']=$value;
        $this->attributes['slug']=Str::slug($value);
    }
}
