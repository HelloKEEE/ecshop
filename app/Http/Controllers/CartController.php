<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Repository\CartRepository;
use App\Repository\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function __construct(
        protected CartRepositoryInterface $CartRepository,
    ) {}

    public function add(Request $request)
    {
        if($request->isMethod("POST")) {

            $user_id = $request->input('user_id');
            $product_id = $request->input('product_id');
            $quantity = $request->input('quantity');

            $data = array();

            if($user_id) {
                $data["user_id"] = $user_id;
            }
            if($product_id) {
                $data["product_id"] = $product_id;
            }
            if($quantity) {
                $data["quantity"] = $quantity;
            }

            
            $cart = $this->CartRepository->doAdd($data);

            return redirect()->route("cart.detail");

        } else {

            $products = Product::all();

            return view("cart.add", array(
                "products" => $products
            ));
        }
    }

    public function detail(Request $request){

        $user_id = session('user_id');


        $carts = $this->CartRepository->doDetail($user_id);


        return view("cart.detail", array(
            "carts" => $carts
        ));
    }
}

