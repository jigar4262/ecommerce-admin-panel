<?php

namespace App\Services;

use App\Repositories\AdminGroupCategoryRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AadminGroupCategoryService
{
    protected $repo;

    public function __construct(AdminGroupCategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create($data)
    {
        
        // dd($data);
        $validator = Validator::make($data, [
            'name' => 'required|unique:admin_group_categories,name'
        ]);

        if ($validator->fails()) {
             
            throw new \Exception($validator->errors()->first());
        }

        // $data['created_by'] = session('admin_id');

        return $this->repo->crate($data);
    }

    public function getAll()
    {
        return $this->repo->getAll();
    }

    public function delete($id)
    {
        $admin_group_category = $this->repo->find($id);
        return $this->repo->delete($admin_group_category);
    }

    public function edit($id)
    {
        return $this->repo->find($id);
    }


    public function update($id, $data)
    {
        $validate = Validator::make($data, [
            'name' => ['required',
            Rule::unique('admin_group_categories', 'name')->ignore($id)]
        ]);

        if($validate->fails()){
           throw new Exception($validate->errors()->first());
        }
        $admin_group_category = $this->repo->find($id);
        
        return $this->repo->update($admin_group_category, $data);

    }
}
