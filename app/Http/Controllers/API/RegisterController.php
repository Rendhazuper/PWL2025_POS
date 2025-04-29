<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    //Create User
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required',
            'nama' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(). 422);
        }

        $user = UserModel::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
            'nama' => $request->nama,
        ]);

        if($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ], 201);
        } 
            
        return response()->json([
            'success ' => false,
        ], 409);
    }
}
