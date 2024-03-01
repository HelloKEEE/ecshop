<?php
namespace App\Service;

use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use App\Repository\ProductRepository;
use App\Repository\CartRepositoryInterface;
use App\Repository\CartRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


class CartService implements CartServiceInterface{

    public function __construct(
        protected CartRepositoryInterface $cartRepository,
        protected ProductRepositoryInterface $productRepository,
    ) {}


    public function getCart(User $user): Collection{

        $carts = $this->cartRepository->doDetail($user->id);

        return $carts;
    }

    public function add(User $user, Product $product, int $quantity): bool
    {
        // まず、在庫数を確認する
        if(!$this->productRepository->checkStock($product,$quantity)){
            // 在庫がたりなければ、カート追加できなくて、false
            return false;
        }

        try {
            // トランザクションを開始します
            DB::beginTransaction();
            // 既にカートにあるかないかを確認
            if ($this->cartRepository->checkExist($user, $product)) {

                // 既にあった場合　元々にあったQUANTITYの数を変更する。
                $this->cartRepository->updateQuantity($user, $product, $quantity);

            } else {
                // カートにない場合　カートに追加
                $data = array();
                $data["user_id"] = $user->id;
                $data["product_id"] = $product->id;
                $data["quantity"] = $quantity;
                $cart = $this->cartRepository->doAdd($data);
            }

//            throw new \Exception("test");
            // 商品の在庫数を減らす
            $result = $this->productRepository->reduceStock($product, $quantity);

            // トランザクションをコミットします
            DB::commit();
        } catch (\Exception $e) {
            // 例外が発生した場合、トランザクションをロールバックします
            DB::rollBack();

            // 例外を処理します（ログに記録、ユーザーにエラーメッセージを表示など）
            // 以下は簡単な例です
            return false;
        }

        // trueをリターン
        return $result;


    }

    public function reduce(User $user, Product $product, int $quantity = 1): bool
    {

        $data = array();
        $data["user_id"] = $user->id;
        $data["product_id"] = $product->id;

        $carts = $this->cartRepository->search($data);
        if($carts->count() !== 1) {
            return false;
        }

        $cart = $carts->first();

        if($quantity < 0) {
            $cart->quantity -= $quantity;
            $cart->save();

            $this->productRepository->addStock($product, $quantity);
            return true;
        }

        if($cart->quantity < $quantity) {
            return false;
        }

        if($cart->quantity == $quantity) {
            $this->remove($user, $product);
            return true;
        }

        $cart->quantity -= $quantity;
        $cart->save();
        $this->productRepository->addStock($product, $quantity);


        return true;


    }

    public function clear(User $user): bool{

        // 指定したユーザーのすべてのカートレコードを取得し
        // 一件ずつ商品quantityを商品の在庫数に加える
        foreach ($user->carts as $cart) {
            $this->remove($user, $cart->product);
        }

        return true;
    }

    public function remove(User $user, Product $product): bool{

        // カートの一つ商品のみアイテムを削除
        $data = array();
        $data["user_id"] = $user->id;
        $data["product_id"] = $product->id;

        $carts = $this->cartRepository->search($data);
        if($carts->count() !== 1) {
            return false;
        }
        $cart = $carts->first();

        $result = $this->cartRepository->delete($data);

        if($result) {
            // 商品の在庫数を加える
            return $this->productRepository->addStock($product, $cart->quantity);
        }

        // trueをリターン
        return $result;
    }

    public function increase(User $user, Product $product, $quantity = 1)
    {
        return $this->reduce($user, $product, 0-$quantity);
    }
}
