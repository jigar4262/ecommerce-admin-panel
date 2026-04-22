<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AttributeService;
use Illuminate\Http\Request;

class AttributeController extends Controller
{

    protected $service;

    public function __construct(AttributeService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = $this->service->getAll();
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->service->create($request->all());

            return redirect()->route('attributes.index')->with('success', 'Attribute Create Successfully');
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
        $attribute = $this->service->edit($id);
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
        $this->service->update($id,$request->all());
        return redirect()->route('attributes.index')->with('success', 'Attribute Updated Successfully');
        } catch (\Exception $e) {
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
            $this->service->delete($id);

            return redirect()->route('attributes.index')
                ->with('success', 'Attribute deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
