<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository{
    public function create($data){
       return Product::create($data);
    }

    public function get_all(){
        return Product::with('categories')->get();
    }

    public function delete($product){
       return $product->delete();
    }

    public function find($id){
        return Product::findOrFail($id);
    }
}
?>