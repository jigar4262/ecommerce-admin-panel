<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $fillable = ['order_id','status','changed_by'];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function admin(){
        return $this->belongsTo(User::class);
    }
}
