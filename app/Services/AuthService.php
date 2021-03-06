<?php


namespace App\Services;


use App\User;

class   AuthService
{
    public function register($request){
        $user=User::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $token=auth('api')->login($user);
        return $this->respondWithToken($token);
    }
    public function login(){
        $credentials=\request(['email','password']);

        if(! $token=auth('api')->attempt($credentials)){
            return response()->json(['error'=>'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function logout(){
        auth()->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }
    protected function respondWithToken($token){
        return response()->json([
            'access_token' =>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth('api')->factory()->getTTL()*60
        ]);

    }
}
