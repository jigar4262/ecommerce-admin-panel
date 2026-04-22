<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\OptionService;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    protected $option_service;

    public function __construct(OptionService $option_service)
    {
        $this->option_service = $option_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {
       $options= $this->option_service->getAll();
       return view('admin.options.index',compact('options'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.options.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->option_service->create($request->all());
            return redirect()->route('options.index')->with('success', 'Option created successfully.');
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
        $option = $this->option_service->edit($id);
        // dd($option);
        return view('admin.options.edit', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
         try {
            $this->option_service->update($id, $request->all());
            return redirect()->route('options.index')->with('success', 'Option updated successfully.');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->option_service->delete($id);
        return redirect()->route('options.index')->with('success', 'Option deleted successfully.');
    }
}
