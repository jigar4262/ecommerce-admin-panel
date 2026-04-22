<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemTab extends Model
{
    public function child(){
        return $this->hasMany(SystemTab::class,'parent_id');
    }

    public function parent(){
        return $this->belongsTo(SystemTab::class,'parent_id');
    }
}
