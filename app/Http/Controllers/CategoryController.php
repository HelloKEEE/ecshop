<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Repository\CategoryRepository;
use App\Repository\CategoryRepositoryInterface;

use Closure;

class CategoryController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
    ) {}

    public function index(Request $request)
    {        

        $id = $request->input('id');
        $name = $request->input('name');
        $introduction = $request->input('introduction');

        $data = array();
        if($id) {
            $data["id"] = $id;
        }
        if($name) {
            $data["name"] = $name;
        }
        if($introduction) {
            $data["introduction"] = $introduction;
        }

        
        $categories = $this->categoryRepository->search($data);

        return view("category.index", array(
            "categories" => $categories
        ));

    }

    public function detail(Request $request, $id = null)
    {
        
        $category_id = $id;
        $category = Category::find($id);
        
        return view("category.detail", array("category" => $category));
       
    }

    public function delete(Request $request)
    {

        $id = $request->input('id');
        
        $category = Category::findOrFail($id);

        $category->delete();
        return redirect()->route('category.index');
    }
    

    public function add(Request $request)
    {
      
        $name = $request->input('name');
        $introduction = $request->input('introduction');

        if ($request->isMethod("POST")){

            $validator = Validator::make($request->all(), [
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
                'introduction' => ["required", "max:10",
                function (string $attribute, mixed $value, Closure $fail) {
                    if (strpos($value, "fuck") !== false) {
                        $fail("badwordsを入力しないでください。");
                    }
                }
            ],
            ], [
                    "name.required" => "名前を入力してください。",
                    "introduction.required" => "説明を入力してください。",
                ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $category = new Category();

            $category->name = $name;
            $category->introduction = $introduction;
            $category->save();
    
            return redirect()->route('category.index');
        } else {
            return view("category.add");
        }

    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $introduction = $request->input('introduction');

        if ($request->isMethod("POST")){

            $validator = Validator::make($request->all(), [
                'id' => [
                    'required',
                    'integer',
                    'exists:categories,id',
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (strpos($value, "fuck") !== false) {
                            $fail("badwordsを入力しないでください。");
                        }
                    }
                ],
                'name' => [
                    'required', 
                    'max:255',
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (strpos($value, "fuck") !== false) {
                            $fail("badwordsを入力しないでください。");
                        }
                    }
                ],
                'introduction' => ["required", "max:10",
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (strpos($value, "fuck") !== false) {
                            $fail("badwordsを入力しないでください。");
                        }
                    }
                ],
            ], [
                    "id.required" => "IDを入力しないと編集できません。",
                    "id.integer" => "数字を入力してください。",
                    "id.exists" => "IDは存在しません。",
                    "name.required" => "名前を入力してください。",
                    "introduction.required" => "説明を入力してください。",
                    
            ]);

 
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $category = Category::find($id);
            $category->name = $name;
            $category->introduction = $introduction;
            $category->save();


            $categories = Category::all();

            return redirect()->route('category.index');
        } else {
            return view("category.edit");
        }
    }

    
}
