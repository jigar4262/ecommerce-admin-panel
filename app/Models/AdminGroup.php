<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminGroup extends Model
{
    protected $fillable = ['name','admin_group_category_id','accessed_tabs'];

    public function category(){
        return $this->belongsTo(AdminGroupCategory::class,'admin_group_category_id');
    }

    protected $casts = [
        'accessed_tabs'=>'array'
    ];
}
