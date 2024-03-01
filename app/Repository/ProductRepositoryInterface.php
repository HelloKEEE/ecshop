<?php
namespace App\Repository;

use App\Models\Product;

interface ProductRepositoryInterface
{
    
    // category一覧を取得する
    /**
     * parameter
     * $date = array("id" => "1", "name" => "a")
     * $date = array("name" => "a")
     * return
     * Productionのcollection
     */
    public function search(array $data);

    public function save(array $data);

    public function dodelete(array $data);
    
    public function dodetail(array $data);

    public function checkStock(Product $product, int $quantity): bool;

    public function reduceStock(Product $product, int $quantity);

    public function addStock(Product $product, int $quantity);

}