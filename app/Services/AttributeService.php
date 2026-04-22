<?php

namespace App\Services;

use App\Repositories\AttributeRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AttributeService
{
    protected $repo;

    public function __construct(AttributeRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|unique:attributes,name'
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        $data['created_by'] = session('admin_id');

        return $this->repo->crate($data);
    }

    public function getAll()
    {
        return $this->repo->getAll();
    }

    public function delete($id)
    {
        $attribute = $this->repo->find($id);
        return $this->repo->delete($attribute);
    }

    public function edit($id)
    {
        return $this->repo->find($id);
    }


    public function update($id, $data)
    {
        $validate = Validator::make($data, [
            'name' => ['required',
            Rule::unique('attributes', 'name')->ignore($id)]
        ]);

        if($validate->fails()){
           throw new Exception($validate->errors()->first());
        }
        $attribute = $this->repo->find($id);
        
        return $this->repo->update($attribute, $data);

    }
}
