<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Repository\ProductRepository;
use App\Repository\ProductRepositoryInterface;
use App\Repository\CategoryRepository;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use Closure;


class ProductController extends Controller
{

    public function __construct(
        protected ProductRepositoryInterface $ProductRepository,
        protected CategoryRepositoryInterface $categoryRepository,
    ) {}

    
    public function index(Request $request)
    {        

        $id = $request->input('id');
        $name = $request->input('name');
        $price = $request->input('price');

        $data = array();
        if($id) {
            $data["id"] = $id;
        }
        if($name) {
            $data["name"] = $name;
        }
        if($price) {
            $data["price"] = $price;
        }

        
        $products = $this->ProductRepository->search($data);

        return view("product.index", array(
            "products" => $products
        ));

    }

    public function detail(Request $request, $id = null)
    {
        $product = $this->ProductRepository->dodetail($id);

       
        
        return view("product.detail", array("product" => $product));
       
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        
        $data = array();
        if($id) {
            $data["id"] = $id;
        }

        $products = $this->ProductRepository->dodelete($data);

        return redirect()->route('product.index');
    }
    

    public function add(Request $request)
    {

      
        $name = $request->input('name');
        $price = $request->input('price');
        $category_id = $request->input('category_id');

        if ($request->isMethod("POST")){

            $validator = Validator::make($request->all(), $this->getValidationRules("add"), $this->getValidationMessages("add"));

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = array();
            $data["name"] = $name;
            $data["price"] = $price;
            $data["category_id"] = $category_id;

            $products = $this->ProductRepository->save($data);

            return redirect()->route('product.index');
        } else {

            $categories = $this->categoryRepository->search(array());

            return view("product.add", ["categories" => $categories]);
        }

    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $price = $request->input('price');
        $category_id = $request->input('category_id');
        

        if ($request->isMethod("POST")){

            $validator = Validator::make($request->all(), $this->getValidationRules("edit"), $this->getValidationMessages("edit"));

 
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $data = array();
            $data["id"] = $id;
            $data["name"] = $name;
            $data["price"] = $price;
            $data["category_id"] = $category_id;

            $products = $this->ProductRepository->save($data);

            return redirect()->route('product.index');
        } else {
            return view("product.edit");
        }
    }


    private function getValidationRules(string $type)
    {

        $result  = [
            'name' => [
                'required', 
                'unique:categories,name', 
                'max:255',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (strpos($value, "fuck") !== false) {
                        $fail("badwordsを入力しないでください。");
                    }
                }
            ],
            'price' => ["required", "integer"],
            'category_id' => ["required", "integer"]
        ];
        if($type == "add") {
            $result["id"] = [
                'required',
                'integer',
                'exists:products,id',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (strpos($value, "fuck") !== false) {
                        $fail("badwordsを入力しないでください。");
                    }
                }
            ];

        }

        return $result; 
    }

    private function getValidationMessages(string $type)
    {
        $result = [
            "name.required" => "名前を入力してください。",
            "price.required" => "価格を入力してください。",
            "price.integer" => "数字を入力してください。",
            "category_id.required" => "カテゴリを入力してください。",
            "category_id.integer" => "カテゴリIDを数字で入力してください。"
        ];

        if($type == "add") {

            $result["id.required"] = "IDを入力しないと編集できません。";
            $result["id.integer"] = "数字を入力してください。";
            $result["id.exists"] = "IDは存在しません。";

        }
        return $result;
    }
}
