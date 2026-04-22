<?php
namespace App\Repositories;
use App\Models\Option;
    
class OptionRepository{

    public function create($data){
        return Option::create($data);
    }

    public function getAll(){
        return Option::with('values')->latest()->get();
    }

    public function find($id){
        return Option::findorFail($id);
    }

    public function get_by_id($id){
        return Option::with('values')->findorFail($id);
    }

    public function delete($option){
    return $option->delete();
    }

    public function update($option, $data){
        return $option->update($data);
    }
}

?>