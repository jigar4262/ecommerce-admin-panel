<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    protected $product_service;

    public function __construct(ProductService $service)
    {
        $this->product_service=$service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products= $this->product_service->getAll();
        // dd($products);
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd('test');
        $categories= Category::where('status',1)->get();
        $attributes= Attribute::where('status',1)->get();
        $options=Option::with('values')->where('status',1)->get();
        return view('admin.products.create', compact('categories', 'attributes', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
             
            $this->product_service->create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Product created successfully'
            ]);

        } catch (ValidationException $e) {

            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);
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
        $categories= Category::where('status',1)->get();
        $attributes= Attribute::where('status',1)->get();
        $options=Option::with('values')->where('status',1)->get();
        $product= Product::with([
            'categories',
            'images',
            'attributes',
            'discounts.prices',
            'options.option.values',
            'options.values.prices',
            'options.values.images'
        ])->findOrFail($id);

    
        return view('admin.products.edit', compact('categories', 'attributes', 'options','product'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
         try {
             
            $this->product_service->update($id,$request->all());

            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully'
            ]);

        } catch (ValidationException $e) {

            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->product_service->delete($id);

        return redirect()->route('products.index')->with('success','product Deleted Successfully');
    }

    public function loadOption(Request $request){
        
    $option= Option::with('values')->findOrFail($request->option_id);
    // dd($option);

    $has_values=$option->values->count()>0;

    return view('admin.products.optionPanel',compact('option','has_values'))->render();
    }
}
