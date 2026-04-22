<?php
namespace App\Repositories;

use App\Models\Attribute;

class AttributeRepository{
    public function crate($data){
        return Attribute::create($data);
    }

    public function getAll(){
        return Attribute::latest()->get();
    }

    public function find($id){
        return Attribute::findorFail($id);
    }

    public function delete($attribute){
    return $attribute->delete();
    }

    public function update($attribute, $data){
        return $attribute->update($data);
    }
}

?>