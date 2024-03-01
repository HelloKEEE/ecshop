<?php
namespace App\Repository;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;

class ProductRepository implements ProductRepositoryInterface
{
    public function reduceStock(Product $product, int $quantity) {

        if($product->stock < $quantity) {
            return false;
        }
        $product->stock -= $quantity;
        $product->save();
        return true;

    }

    public function addStock(Product $product, int $quantity) {

        $product->stock += $quantity;
        $product->save();

        return true;

    }


    public function checkStock(Product $product, int $quantity): bool{

        if ($product->stock >= $quantity) {
            return true;
        } else {
            return false;
        }
    }

    public function search(array $data)
    {
        $product = Product::query();

        if(!empty($data["id"])) {
            $product->where('id', 'like', '%' . $data["id"] . '%' );
        }
        if(!empty($data["name"])) {
            $product->where('name', 'like', '%' . $data["name"] . '%' );
        }
        if(!empty($data["price"])) {
            $product->where('price', 'like', '%' . $data["product"] . '%' );
        }

        $product = $product->get();

        return $product;
    }

    public function save(array $data){

        if(!empty($data["id"])) {
            $Product = Product::find($data["id"]);
        } else {
            $Product = new Product();
        }

        $Product->name = $data["name"];
        $Product->price = $data["price"];
        $Product->category_id = $data["category_id"];
        $Product->save();

        return $Product;
    }

    public function dodelete(array $data){
        $id = $data["id"];

        $product = Product::findOrFail($id);

        $product->delete();

        return $product;
    }

    public function dodetail($id){


        $product = product::find($id);

        dd($product);

        return $product ;
    }

}
