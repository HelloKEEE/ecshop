<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;

class SessionCartService implements CartServiceInterface
{

    private $cartName = "cart";

    /**
     * @inheritDoc
     */
    public function add(User $user, Product $product, int $quantity): bool
    {
        $cart = Session::get($this->cartName, new Collection());

        // まず、在庫数を確認する
        if($quantity > $product->stock) {
            //quantityはproductのstockより少ない場合
            return false;
        }

        $newAddProduct = true;

        foreach ($cart as $oneRecord) {
            if($oneRecord->product_id == $product->id) {
                $newAddProduct = false;
                $oneRecord->quantity += $quantity;
            }
        }

        if($newAddProduct) {
            // 現在のカートの中に新商品をsessionに保存する。
            $cartModel = new Cart();
            $cartModel->user_id = $user->id;
            $cartModel->product_id = $product->id;
            $cartModel->quantity = $quantity;

            $cart->add(
                $cartModel
            );
        }

        Session::put($this->cartName, $cart);

        return true;
    }

    public function reduce(User $user, Product $product, int $quantity = 1): bool
    {
        $cart = Session::get($this->cartName, new Collection());

        $newCart = new Collection();

        // 現在のカートの商品レコードQUANTITY-1。
        foreach ($cart as $oneRecord) {
            if($oneRecord->product->id == $product->id) {

                if($oneRecord->quantity < $quantity) {
                    return false;
                }

                if($oneRecord->quantity == $quantity) {
                    continue;
                }


                $oneRecord->quantity -= $quantity;
                $newCart->add($oneRecord);
            }
        }

        Session::put($this->cartName, $newCart);

        return true;
    }

    public function increase(User $user, Product $product, $quantity = 1): bool{

        $cart = Session::get($this->cartName, new Collection());

        // まず、在庫数を確認する
        if($quantity > $product->stock) {
            //quantityはproductのstockより少ない場合
            return false;
        }

        $recordFound = false;
        // 現在のカートの商品レコードQUANTITY+1。
        foreach ($cart as $oneRecord) {
            if($oneRecord->product->id == $product->id) {
                $recordFound = true;
                $oneRecord->quantity += $quantity;
            }
        }

        if(!$recordFound) {

            $cartModel = new Cart();
            $cartModel->user_id = $user->id;
            $cartModel->product_id = $product->id;
            $cartModel->quantity = $quantity;

            // 現在のカートの中に新商品をsessionに保存する。
            $cart->add($cartModel);
        }

        return true;
    }

    public function clear(User $user): bool
    {
        Session::put($this->cartName, new Collection());
        return true;
    }


    public function remove(User $user, Product $product): bool
    {
        // 現在のカート情報をセッションから取得する
        $cart = Session::get($this->cartName, new Collection());

        $newCart = new Collection();

        // 現在のカートの中に削除したい商品レコード以外のものを改めてsessionに保存する。
        foreach($cart as $oneRecord) {

            if($oneRecord->product->id != $product->id) {
                $newCart->add($oneRecord);
            }

        }

        Session::put($this->cartName, $newCart);

        return true;
    }

    public function getCart(User $user): Collection
    {
        return Session::get($this->cartName, new Collection());
    }

}
