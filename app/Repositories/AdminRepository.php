<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{
    public function create($data)
    {
       return Admin::create($data);
    }

    public function getAll()
    {
        return Admin::with('adminGroup')->latest()->get();
    }

    public function find($id)
    {
        return Admin::findorFail($id);
    }

    public function delete($AdminGroup)
    {
        return $AdminGroup->delete();
    }

    public function update($AdminGroup, $data)
    {
        return $AdminGroup->update($data);
    }
}
