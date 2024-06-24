<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
   
        if($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first());
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $auth = Auth::user(); 
            $data['user'] =  new UserResource($auth);
            $data['token'] =  $auth->createToken('auth_token')->plainTextToken;
   
            return response()->api($data);
        }
        else {
            return response()->api([], 1, 'These credentials do not match out records');
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
   
        if($validator->fails()){
            return response()->api([], 1, $validator->errors()->first()); 
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        
        $data['user'] =  new UserResource($user);
        $data['token'] =  $user->createToken('auth_token')->plainTextToken;
   
        return response()->api($data);
    }

    public function user(Request $request) {
        $data['user'] =  new UserResource($request->user());

        return response()->api($data);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->api([], 0, 'User logged out successfully');
    }
}