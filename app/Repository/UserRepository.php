<?php
namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository implements UserRepositoryInterface
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
    public function doadd(array $data){

        $User = new User();
        $User->name = $data["name"];
        $User->email = $data["email"];
        $User->password = $data["password"];
        $User->save();

        return $User;
    }

    public function dodetail($id){
        
        $user = user::find($id);

        
        return $user;
    }

    public function dodelete($data){
        

        $user = User::findOrFail($data["id"]);

        $user->delete();

        return $user;
    }
}