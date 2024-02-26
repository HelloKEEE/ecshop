<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {

        $carts = DB::table('carts')->get();


        return view("carts", array(
            "carts" => $carts
        ));
    }
}

