<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Category extends Model
{
    public $fillable = ['name','slug','parent_id','status','created_by'];

    public function parent(){
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function child(){
        return $this->hasMany(Category::class,'parent_id');
    }

    public function setNameAttribute($value){
        $this->attributes['name']=$value;
        $this->attributes['slug']=Str::slug($value);
    }
}
