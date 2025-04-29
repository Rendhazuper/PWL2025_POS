<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //read user
    public function index()
    {
        return UserModel::all();
    }

    //read user by username
    public function show(UserModel $user)
    {
        return UserModel::find($user);
    }
    
    //Edit User 
    public function update(Request $request, UserModel $user)
    {
        $user->update($request->all());
        return UserModel::find($user); 
    }

    //delete user
    public function destroy(UserModel $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil terhapus'
        ]);
    }
}
