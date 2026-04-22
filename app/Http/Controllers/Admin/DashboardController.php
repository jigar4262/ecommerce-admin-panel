<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $product=Product::where('status',1)->count();
        $category=Category::where('status',1)->count();
        $order=Order::count();
        $users=Admin::count();
        // dd($order);
        return view('admin.dashboard',compact('product','category','order','users'));
    }
}
