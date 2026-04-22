<?php

namespace App\Services;

use App\Repositories\AdminGroupRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminGroupService
{
    protected $admin_group_repo;
    public function __construct(AdminGroupRepository $adminGroupRepository)
    {
        $this->admin_group_repo = $adminGroupRepository;
    }

    public function create($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|unique:admin_groups,name',
            'admin_group_category_id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data['name'] = $data['name'];
        $data['admin_group_category_id'] = $data['admin_group_category_id'];
        $data['accessed_tabs'] = $data['accessed_tabs'] ?? [];

        $this->admin_group_repo->create($data);
    }

    public function getAll()
    {
        return $this->admin_group_repo->getAll();
    }

    public function delete($id)
    {
        $admin_group = $this->admin_group_repo->find($id);
        return $this->admin_group_repo->delete($admin_group);
    }

    public function edit($id)
    {
        return $this->admin_group_repo->find($id);
    }


    public function update($data, $id)
    {
        $validator = Validator::make($data, [
            'name' => ['required', Rule::unique('admin_groups', 'name')->ignore($id)],
            'admin_group_category_id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $admin_groups = $this->admin_group_repo->find($id);
        $data['name'] = $data['name'];
        $data['admin_group_category_id'] = $data['admin_group_category_id'];
        $data['accessed_tabs'] = $data['accessed_tabs'] ?? [];

        return $this->admin_group_repo->update($admin_groups, $data);
    }
}
