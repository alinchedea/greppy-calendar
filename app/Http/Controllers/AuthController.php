<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email' , 'unique:users'],
            'password' => 'required',
            'password_confirmation' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {

            return response()->json($validator->errors(), 417);
        }

        $response=$this->authService->register($request);
        return response()->json($response, 200);
    }

    public function login (){
        $response=$this->authService->login();
        return response()->json($response, 200);
    }

    public function logout(){
        $response=$this->authService->logout();
        return response()->json($response, 200);
    }

    public function check(){

        $userId = auth('api')->id();
        return response()->json(['user_id'=>$userId], 200);
    }
}
