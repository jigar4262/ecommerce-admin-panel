<?php
namespace App\Repositories;

use App\Models\AdminGroupCategory;


class AdminGroupCategoryRepository{
    public function crate($data){
        return AdminGroupCategory::create($data);
    }

    public function getAll(){
        return AdminGroupCategory::latest()->get();
    }

    public function find($id){
        return AdminGroupCategory::findorFail($id);
    }

    public function delete($AdminGroupCategory){
    return $AdminGroupCategory->delete();
    }

    public function update($AdminGroupCategory, $data){
        return $AdminGroupCategory->update($data);
    }
}

?>