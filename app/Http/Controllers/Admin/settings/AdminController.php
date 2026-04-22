<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminGroup;
use App\Models\SystemTab;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $service;

    public function __construct(AdminService $admin_service)
    {
        $this->service = $admin_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->service->getAll();

        return view('admin.settings.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin_groups = AdminGroup::where('id', '!=', 1)->get();
        $system_tabs = SystemTab::with('child')->whereNull('parent_id')->get();
        return view('admin.settings.admin.create', compact('admin_groups', 'system_tabs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->service->create($request->all());
            return redirect()->route('admins.index')->with('success', 'Admin Group Created Successfully');
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
        $admin_groups = AdminGroup::where('id', '!=', 1)->get();
        $system_tabs = SystemTab::with('child')->whereNull('parent_id')->get();
        
        $admin=$this->service->edit($id);
        $group_data=AdminGroup::find($admin->admin_group_id);
        $group_tabs=$group_data->accessed_tabs;
        $extra_tabs=$admin->accessed_tabs;
        $removed_tabs=$admin->removed_tabs;
        // dd($extra_tabs);
        $full_tabs=
        array_values(array_diff(
            array_merge($group_tabs, $extra_tabs ?? []),
            $removed_tabs ?? []
        ));
        
        return view('admin.settings.admin.edit', compact('admin_groups', 'system_tabs','admin','full_tabs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         try {
            $this->service->update($request->all(),$id);
            return redirect()->route('admins.index')->with('success', 'Admin user Updated Successfully');
        } catch (\Exception $e) {
            throw ($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->delete($id);
        return redirect()->route('admins.index')->with('success', 'Admin user deleted successfully');
    }

    public function adminGroup(Request $request)
    {
        $admin_group_id = $request->admin_group_id;
        if (isset($admin_group_id)) {
            $admin_group = AdminGroup::find($admin_group_id);
            $tabs = $admin_group->accessed_tabs;

            return response()->json($tabs ?? []);
        }
    }
}
