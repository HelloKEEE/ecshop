<?php
namespace App\Repository;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;

interface CartRepositoryInterface
{
    
    
    public function search(array $data);

    public function doedit(array $data);

    public function doAdd(array $data);
    
    public function doDetail(array $data);

    public function delete(array $data);

    public function checkExist(User $user,Product $product): bool;

    public function updateQuantity(User $user,Product $product,$quantity);

    public function update(User $user,Product $product,$quantity);

}