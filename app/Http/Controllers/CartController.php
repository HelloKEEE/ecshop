<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Product;
use App\Repository\CartRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Service\CartServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function __construct(
        protected CartRepositoryInterface    $cartRepository,
        protected ProductRepositoryInterface $productRepository,
        protected CartServiceInterface       $cartService,
    )
    {
    }

    public function index(Request $request)
    {

        $user = Auth::user();

        $carts = $this->cartService->getCart($user);

        return view("cart.index", array(
            "carts" => $carts
        ));
    }

    public function add(Request $request)
    {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        $user = Auth::user();
        $product = Product::find($product_id);

        $validator = Validator::make($request->all(), [
            'quantity' => [
                'required',
                'integer',
            ]
        ], [
            "quantity.required" => "入力しないと入れません。",
            "quantity.integer" => "数字を入力してください。"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $result = $this->cartService->add($user, $product, $quantity);

        if (!$result) {
            $request->session()->flash("error", "can not add to cart");
            return redirect()->back();
        }

        return redirect()->route('cart.index');

    }

    public function update(Request $request)
    {

        $quantity = intval($request->input('quantity'));
        $product_id = $request->input('product_id');

        $user = Auth::user();
        $product = Product::find($product_id);
        $cart_quantity = $request->input('cart_quantity');

        $validator = Validator::make($request->all(), [
            'quantity' => [
                'required',
            ]
        ], [
            "quantity.required" => "入力しないと変更できせん。",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if (!$quantity) {
            $result = $this->cartService->reduce($user, $product, $cart_quantity);
        } else {
            $result = $this->cartRepository->update($user, $product, $quantity);
        }

        if (!$result) {
            $request->session()->flash("error", "Can not update quantity");
            return redirect()->back();
        }

        return redirect()->route('cart.index');
    }

    public function increase(Request $request)
    {
        $product_id = $request->input('product_id');


        $user = Auth::user();
        $product = Product::find($product_id);

        $result = $this->cartService->increase($user, $product);

        if (!$result) {
            $request->session()->flash("error", "increase fail");
            return redirect()->back();
        }

        return redirect()->route('cart.index');

    }

    public function reduce(Request $request)
    {
        $product_id = $request->input('product_id');


        $user = Auth::user();
        $product = Product::find($product_id);

        $result = $this->cartService->reduce($user, $product);

        if (!$result) {
            $request->session()->flash("error", "reduce fail");
            return redirect()->back();
        }

        return redirect()->route('cart.index');

    }

    public function remove(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::find($product_id);


        $result = $this->cartService->remove(Auth::user(), $product);

        if (!$result) {
            $request->session()->flash("error", "remove fail");
            return redirect()->back();
        }

        return redirect()->route('cart.index');

    }

    public function clear(Request $request)
    {

        $user = Auth::user();

        $this->cartService->clear($user);

        return redirect()->route('cart.index');


    }
}

