<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryService
{
    protected $repo;
    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create($data)
    {
        $validate = Validator::make($data, [
            'name' => 'required|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        if($validate->fails()){
            throw new \Exception($validate->errors()->first());
        }
        $data['created_by']=session('admin_id');

        return $this->repo->create($data);
    }

    public function get_all(){
        return $this->repo->get_all();
    }

    public function delete($id){
       $category=$this->repo->find($id);

       return $this->repo->delete($category);
    }

    public function edit($id){
        return $this->repo->find($id);
    }

    public function update($id,$data){
       $category=$this->repo->find($id);

        $validate = Validator::make($data, [
            'name' =>[
                'required',
                Rule::unique('categories','name')->ignore($id)
            ],
            'parent_id' => 'nullable|exists:categories,id',
            'status'=>'required|in:0,1'

        ]);

        if($validate->fails()){
            throw new \Exception($validate->errors()->first());
        }

        return $this->repo->update($category,$data);
    }
}
