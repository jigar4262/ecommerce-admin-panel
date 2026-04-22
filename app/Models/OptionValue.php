<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $fillable = [ 'option_id','value_name','sort_order','image'];

    public function option(){
    return $this->belongsTo(Option::class);
    }
}
