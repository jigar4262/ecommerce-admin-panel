<?php

namespace App\Repositories;

use App\Models\AdminGroup;

class AdminGroupRepository
{
    public function create($data)
    {
        AdminGroup::create($data);
    }

    public function getAll()
    {
        return AdminGroup::with('category')->latest()->get();
    }

    public function find($id)
    {
        return AdminGroup::findorFail($id);
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
