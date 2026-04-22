<?php
namespace App\Repositories;

use App\Models\Coupon;
use App\Services\CouponService;

class CouponRepository
{

public function create($data){
    return Coupon::create($data);
}   

public function get_all(){
     return Coupon::with('categories','products')->latest()->get();    
}

public function find($id){
    return Coupon::findOrFail($id);}

    public function delete($coupon){
        return $coupon->delete();
    }

    public function update($coupon,$data){
        return $coupon->update($data);
    }

}
?>