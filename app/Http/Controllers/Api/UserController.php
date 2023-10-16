<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // USER REGISTER - POST
    public function register(Request $request)
    {

        // validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        // create user data and save

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);

        $user->save();

        // send response
        return response()->json([
            'status' => 1,
            'message' => 'User registered successfully',
        ], 200);
    }

    // USER LOGIN - POST
    public function login(Request $request)
    {
        // validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // verify user and token

        if(!$token = auth()->attempt(['email'=>$request->email,'password'=>$request->password])){

            return response()->json([
                'status' => 0,
                'message' => 'Invalid email or password',
            ], 401);
        }


        // send response

        return response()->json([
            'status' => 1,
            'message' => 'User logged in successfully',
            'access_token' => $token,
        ]);

    }

    // USER PROFILE  - GET
    public function profile()
    {

        $user = auth()->user();

        return response()->json([
            'status'=>1,
            'message' => 'User Information',
            'data' => $user
        ],200);
    }

    // USER LOGOUT - GET
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status'=>1,
            'message' => 'User logged out successfully'
        ],200);



    }

}
