<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

use function PHPUnit\Framework\throwException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $cat_service;
    public function __construct(CategoryService $service)
    {
        $this->cat_service = $service;
    }
    public function index()
    {
        $categories = $this->cat_service->get_all();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        try {
            $this->cat_service->create($request->all());
            return redirect()->route('categories.index')->with('success', 'Category created Successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['name' => $e->getMessage()])->withInput();
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
         $category=$this->cat_service->edit($id);

         $categories=Category::whereNull('parent_id')->where('id','!=',$id)->get();
         return view('admin.categories.edit', compact('category', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $this->cat_service->update($id,$request->all());
            return redirect()->route('categories.index')->with('success','Category Updated Successfully');
        }catch(\Exception $e){
           return back()->withErrors(['name' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $this->cat_service->delete($id);

            return redirect()->route('categories.index')
                ->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
