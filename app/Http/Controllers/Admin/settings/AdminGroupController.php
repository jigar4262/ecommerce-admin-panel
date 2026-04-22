<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\AdminGroupCategory;
use App\Models\SystemTab;
use App\Services\AdminGroupService;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class AdminGroupController extends Controller
{

    protected $service;

    public function __construct(AdminGroupService $admin_service)
    {
        $this->service = $admin_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_groups = $this->service->getAll();
        //  dd($admin_groups);
        return view('admin.settings.admingroup.index', compact('admin_groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin_group_categories = AdminGroupCategory::all();
        $system_tabs = SystemTab::with('child')->whereNull('parent_id')->get();

        return view('admin.settings.admingroup.create', compact('admin_group_categories', 'system_tabs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->service->create($request->all());
            return redirect()->route('adminGroups.index')->with('success', 'Admin Group Created Successfully');
        } catch (\Exception $e) {
            throw ($e);
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
        $admin_group = $this->service->edit($id);
        $admin_group_categories = AdminGroupCategory::all();
        $system_tabs = SystemTab::with('child')->whereNull('parent_id')->get();

        return view('admin.settings.admingroup.edit', compact('admin_group','admin_group_categories','system_tabs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
         try {
            $this->service->update($request->all(),$id);
            return redirect()->route('adminGroups.index')->with('success', 'Admin Group Updated Successfully');
        } catch (\Exception $e) {
            throw ($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $admin_group=$this->service->delete($id);
       return redirect()->route('adminGroups.index')->with('success','Admin Group Deleted Successfully');
    }
}
