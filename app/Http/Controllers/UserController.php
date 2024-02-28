<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use Closure;

class UserController extends Controller
{
    

    public function __construct(
        protected UserRepositoryInterface $UserRepository,
    ) {}

    
    public function login(Request $request){

        if($request->isMethod("POST")) {
            if(Auth::attempt(['email' => $request->input("email"), 'password' => $request->input("password")])) {
                
                session()->flash('success', 'ログイン成功しました。');

                $email = $request -> input("email");
                $user = User::where('email', $email)->first(); 
                
                session(['user_name' => $user['name']]);
                session(['user_id' => $user['id']]);

                return redirect()->route("user.index");

            } else {

                session()->flash('error', 'ログイン失敗しました。');

            }

        }
        return view("user.login");
    }

    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();

        return redirect()->route("login");
    }

    public function index(Request $request)
    {        

        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $email_verified_at = $request->input('email_verified_at');
        $password = $request->input('password');

        $data = array();
        if($id) {
            $data["id"] = $id;
        }
        if($name) {
            $data["name"] = $name;
        }
        if($email) {
            $data["email"] = $email;
        }
        if($email_verified_at) {
            $data["email_verified_at"] = $email_verified_at;
        }
        if($password) {
            $data["password"] = $password;
        }

        
        $users = $this->UserRepository->search($data);

        return view("user.index", array(
            "users" => $users
        ));

    }

    public function detail(Request $request, $id = null)
    {
        
        $user = $this->UserRepository->dodetail($id);

        $user = user::find($id);
        
        return view("user.detail", array("user" => $user));
       
    }

    public function delete(Request $request)
    {

        $id = $request->input('id');
        
        $data = array();
        if($id) {
            $data["id"] = $id;
        }

        $user = $this->UserRepository->dodelete($data);

        

        return redirect()->route('user.index');
    }
    

    public function add(Request $request)
    {
      
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

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
                'email' => ["required"],
                'password' => ["required"]
                ], [
                        "name.required" => "名前を入力してください。",
                        "email.required" => "Emailを入力してください。",
                        "password.required" => "passwordを入力してください。",
                    ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = array();
            $data["name"] = $name;
            $data["email"] = $email;
            $data["password"] = $password;

            $Users = $this->UserRepository->doadd($data);

            return redirect()->route('user.index');
        } else {
            return view("user.add");
        }

    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        

        if ($request->isMethod("POST")){

            $validator = Validator::make($request->all(), [
                'id' => [
                    'required',
                    'integer',
                    'exists:products,id',
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (strpos($value, "fuck") !== false) {
                            $fail("badwordsを入力しないでください。");
                        }
                    }
                ],
                'name' => [
                    'required', 
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (strpos($value, "fuck") !== false) {
                            $fail("badwordsを入力しないでください。");
                        }
                    }
                ],
                'email' => ["required"],
                'password' => ["required"],
            ], [
                    "id.required" => "IDを入力しないと編集できません。",
                    "id.integer" => "数字を入力してください。",
                    "id.exists" => "IDは存在しません。",
                    "name.required" => "名前を入力してください。",
                    "email.required" => "Emailを入力してください。",
                    "password.required" => "passwordを入力してください。",
                    
            ]);

 
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $data = array();
            $data["id"] = $id;
            $data["name"] = $name;
            $data["email"] = $email;
            $data["password"] = $password;

            $users = $this->UserRepository->doedit($data);

            return redirect()->route('user.index');
        } else {
            return view("user.edit");
        }
    }
}
