<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Services\AadminGroupCategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminGroupCategoryController extends Controller
{
    protected $admin_group_category_service;

    public function __construct(AadminGroupCategoryService $service)
    {
        $this->admin_group_category_service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_group_categories = $this->admin_group_category_service->getAll();
        return view('admin.settings.admingroupcategory.index', compact('admin_group_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.settings.admingroupcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->admin_group_category_service->create($request->all());
            return redirect()->route('adminGroupCategories.index')->with('success', 'Admin Group Category Created');
        } catch (\Exception $e) {
            return back()->withErrors([
                'name' => $e->getMessage()
            ])->withInput();
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
        $admin_group_category = $this->admin_group_category_service->edit($id);
        return view('admin.settings.admingroupcategory.edit', compact('admin_group_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->admin_group_category_service->update($id,$request->all());
            return redirect()->route('adminGroupCategories.index')->with('success','Category Updated Successfully');
        } catch (Exception $e) {
            return back()->withErrors([
                'name' => $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->admin_group_category_service->delete($id);
            return redirect()->route('adminGroupCategories.index')
                ->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
