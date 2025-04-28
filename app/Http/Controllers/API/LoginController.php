<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $credentials = $request->only('username','password');

        if(!$token = auth()->guard('api')->attempt($credentials)){
            return response()->json([
                'success' => false,
                'message' => 'Username atau Password anda salah'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => auth()->guard('api')->user(),
        ], 200);
    }
}
