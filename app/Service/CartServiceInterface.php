<?php
namespace App\Service;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface CartServiceInterface {

    /**
     * 商品をカートに入れる
     * return
     * 追加成功の場合true
     * 追加失敗の場合false
     */
    public function add(User $user, Product $product, int $quantity): bool;

    // カート内特定の商品の購入数を追加
    public function increase(User $user, Product $product, $quantity = 1);

    // カートのデータを削除
    // カートの特定のレコードの数量を減少する。
    public function reduce(User $user, Product $product, int $quantity = 1): bool;

    // 全部クリアー
    public function clear(User $user): bool;

    // カートの一つ商品のみアイテムを削除
    // カートの特定のレコードを行自体の削除
    public function remove(User $user, Product $product): bool;


    public function getCart(User $user): Collection;



}
