<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
  protected $fillable = ['option_name','option_type_id','status','created_by'];

  public function values(){
    return $this->hasMany(OptionValue::class);
  }
}   
