<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Services\CouponService;
use Exception;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */

    protected $service;

    public function __construct(CouponService $couponService)
    {
        $this->service = $couponService;
    }
    public function index()
    {
      $coupons= $this->service->get_all();
      return view('admin.coupons.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        return view('admin.coupons.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->service->create($request->all());

            return redirect()->route('coupons.index')->with('success', 'Coupon created successfully');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    
        $categories = Category::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        $coupon=Coupon::with('categories','products')->findOrFail($id);
        return view('admin.coupons.edit', compact('coupon', 'categories', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
         try {
            $this->service->update($id,$request->all());

            return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        $this->service->delete($id);
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully');
    }
}
