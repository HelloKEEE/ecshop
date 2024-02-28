<?php
namespace App\Repository;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class CartRepository implements CartRepositoryInterface
{

    public function search(array $data)
    {
        $User = User::query();

        if(!empty($data["id"])) {
            $User->where('id', 'like', '%' . $data["id"] . '%' );
        }
        if(!empty($data["name"])) {
            $User->where('name', 'like', '%' . $data["name"] . '%' );
        }
        if(!empty($data["email"])) {
            $User->where('email', 'like', '%' . $data["email"] . '%' );
        }
        // if(!empty($data["email_verified_at"])) {
        //     $User->where('email_verified_at', 'like', '%' . $data["email_verified_at"] . '%' );
        // }
        if(!empty($data["password"])) {
            $User->where('password', 'like', '%' . $data["password"] . '%' );
        }

        $User = $User->get();


        return $User;
    }


    public function doedit(array $data){
        
        $id = $data["id"];
        $User = User::find($id);

        $User->name = $data["name"];
        $User->email = $data["email"];
        $User->password = $data["password"];
        $User = $User->save();

        return $User;
    }

    public function doAdd(array $data){

        $cart = new Cart();
        $cart->user_id = $data["user_id"];
        $cart->product_id = $data["product_id"];
        $cart->quantity = $data["quantity"];
        $cart->save();

        return $cart;
    }

    public function doDetail($user_id){
        
        
        $carts=Cart::where('user_id',$user_id)->get();

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

    public function dodelete($data){
        

        $user = User::findOrFail($data["id"]);

        $user->delete();

        return $user;
    }
}