<?php

namespace App\Repository;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repository\ProductRepositoryInterface;
use App\Repository\ProductRepository;


class CartRepository implements CartRepositoryInterface
{

    public function __construct(
        protected ProductRepositoryInterface $productRepository,
    )
    {
    }

    public function search(array $data)
    {
        $cart = Cart::query();

        if (!empty($data["id"])) {
            $cart->where('id', $data["id"]);
        }
        if (!empty($data["user_id"])) {
            $cart->where('user_id', $data["user_id"]);
        }
        if (!empty($data["product_id"])) {
            $cart->where('product_id', $data["product_id"]);
        }


        return $cart;
    }


    public function doedit(array $data)
    {

        $id = $data["id"];
        $User = User::find($id);

        $User->name = $data["name"];
        $User->email = $data["email"];
        $User->password = $data["password"];
        $User = $User->save();

        return $User;
    }

    public function doAdd(array $data)
    {


        $cart = new Cart();
        $cart->user_id = $data["user_id"];
        $cart->product_id = $data["product_id"];
        $cart->quantity = $data["quantity"];
        $cart->save();

        return $cart;
    }

    public function doDetail($user_id)
    {


        $carts = Cart::where('user_id', $user_id)->get();

        // foreach ($carts as $cart){
        //     $product_id = $cart['product_id'];
        //     $product= Product::find($product_id);

        //     if($product){
        //         $product_name = $product->name;
        //         $cart['product_name']=$product_name;
        //     }

        //     $user_id = $cart['user_id'];
        //     $user= User::find($user_id);

        //     if($user){
        //         $user_name = $user->name;
        //         $cart['user_name']=$user_name;
        //     }
        // }

        return $carts;
    }

    public function delete($data)
    {

        if (!empty($data['product_id'])) {
            $cart = Cart::where('product_id', $data['product_id'])
                ->where('user_id', $data['user_id']);
        } else {
            $cart = Cart::where('user_id', $data['user_id']);
        }
        $cart->delete();

        return true;
    }

    public function checkExist(User $user, Product $product): bool
    {

        $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->get();


        if ($cart->isNotEmpty()) {
            return true;
        } else {
            return false;
        };
    }

    public function updateQuantity(User $user, Product $product, $quantity)
    {

        $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();
        $cart->quantity += $quantity;
        $cart->save();
        return true;
    }

    public function update(User $user, Product $product, $quantity)
    {

        $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();

        //入力したQUANTITY　は元CARTのQUANTITYより　少なくなった場合
        if ($quantity < $cart->quantity) {

            //余ったQUANTITYを　productのstockを返す
            $newStock = $cart->quantity - $quantity;
            $product->stock += $newStock;
            $product->save();
        }

        //入力したQUANTITY　は元CARTのQUANTITYより　多くなった場合
        if ($quantity > $cart->quantity) {

            //足りないQUANTITYを　productのstockから取得する
            $newStock = $quantity - $cart->quantity;
            $product->stock -= $newStock;
            $product->save();
        }

        $cart->quantity = $quantity;
        $cart->save();

        return true;
    }
}
