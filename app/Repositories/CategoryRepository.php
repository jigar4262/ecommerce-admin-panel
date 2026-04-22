<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository{
    public function create($data){
      return Category::create($data);
    }

    public function get_all(){
     return Category::with('parent')->latest()->get();
    }

    public function find($id){
        return Category::findorFail($id);
    }

    public function delete($category){
       return $category->delete();
    }

    public function update($category,$data){
        return $category->update($data);
    }
}
?>