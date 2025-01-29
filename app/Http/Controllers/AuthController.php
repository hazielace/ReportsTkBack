<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\structure\Helpers\ResponseHelper;
use App\Http\structure\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth as autht;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function Login(Request $request){
        $validator = Validator::make($request->all(), [
            "email" => "required|string|max:100",
            "password" => "required|string|min:4",
        ]);
        if ($validator->fails()) {
            return ResponseHelper::json_fail($validator);
        }
        $username = $request['email'];
        $user = User::where('email', $username)->firstorfail();
        if($user){
         if (!autht::attempt(['email' => $username, 'password' => $request['password']])) {
            return ResponseHelper::json_failnoV(array("errors" =>"Error de password"),"danger");
         }
        }else{
            return ResponseHelper::json_failnoV(array("errors" =>"Error de username"),"warning");
        }
        DB::table('personal_access_tokens')->where('tokenable_id',auth()->user()['id'])->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24);
        $id = $user->id;
        $user = UserRepository::getUserById($id);
        return ResponseHelper::json_token_login($user,$token, "Login Existoso")->withCookie($cookie);
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');
        return ResponseHelper::json_token_login(auth()->user(),"","Usuario deslogeado del sistema")->withCookie($cookie);
    }
}
