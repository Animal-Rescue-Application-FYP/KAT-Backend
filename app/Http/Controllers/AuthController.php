<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public $loginAfterSignUp=true;

    public function register(Request $request){

        $user = new User();
        $user->name =$request->name;
        $user->email =$request->email;
        $user->phone =$request->phone;
        $user->password =bcrypt($request->password);
        $user->save();

        if($this->loginAfterSignUp){
            return $this->login($request);
        }
        return response()->json([
            'status' => 'ok',
            'data' => $user
        ], 200);
    }

    public function login(Request $request){
        $input = $request->only('email', 'password');
        $jwt_token = null;
        if(!$jwt_token = JWTAuth::attempt($input)){
            return response()->json([
                'status' => 'invalid_credentials',
                'message' => 'Invalid Error'
            ], 401);
        }

        return response()->json([
            'status' => 'ok',
            'token' => $jwt_token,
        ]);
    }

    public function logout(Request $request){
        $this->validate($request, [
            'token' => 'required'
        ]);

        try{
            JWTAuth::invalidate($request->token);
            return response()->json([
                'status' => 'ok',
                'message' => 'youre now logged out'
            ]);
        } catch (JWTException $exception){
            return response()->json([
                'status' => 'unknown_error',
                'message' => 'Error is occured from server'
            ], 500);
        }
    }

//    public function getAuthUser(Request $request){
//        $this->validate($request, [
//            'token' => 'required'
//        ]);
//
//        $user = JWTAuth::authenticate($request->token);
//        return response()->json(['user' => $user]);
////        $user = auth()=>user();
////        return response()=>json(["user"=>$user]);
//    }

    public function getAuthUser(Request $request)
//    : \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        return response()->json(['user' => $user]);
    }

    protected function jsonResponse($data, $code = 200){
        return response()->json($data, $code,
        ['Content-Type' => 'application/json;charset=UTF-8','Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
    }
}

