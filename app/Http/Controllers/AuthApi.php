<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthApi extends Controller
{
    public function register()
    {
        $v = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:4',
            'image' => 'mimes:jpg,jpeg,png'
        ]);
        if ($v->fails()) {
            return  response()->json([
                'Status' => 500,
                'Message' => 'Fail to Register',
                'data' => $v->errors()
            ]);
        }

        $name = request()->name;
        $email = request()->email;
        $password = request()->password;
        $image = request()->image; 

        $image_name = uniqid().$image->getClientOriginalName();
        $image->move('/images',$image_name);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'image' => $image
        ]);

        $token = $user->createToken('social')->accessToken;
        return response()->json([
            'status' => 200,
            'message' => 'Success Register',
            'data' => $user,
            'token' => $token
        ]);
    }

    public function login()
    {
        $v = Validator::make(request()->all(), [
            'email' => 'required',
            'password' => 'required|min:4',
        ]); 
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed',
                'data' => $v->errors(),
            ]);
        }
        $email = request()->email;
        $password = request()->password;

        $cre = ['email'=>$email,'password'=>$password];
        if (Auth::attempt($cre)){
            $user = Auth::user();
            $token = $user->createToken('social')->accessToken;
            return response()->json([
                'status' => 200,
                'message' => 'Success Login',
                'data' => $user,
                'token' => $token,
            ]);
        }
        return response()->json([
            'status' => 500, 
            'message' => 'Failed Login',
            'data' => [
                'error' => 'Email or Password Wrong!',
            ]
        ]);
    }
}
