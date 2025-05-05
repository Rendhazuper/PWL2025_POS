<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

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
            'image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Cek apakah username sudah ada
            $existingUser = UserModel::where('username', $request->username)->first();
            
            if ($existingUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username sudah terdaftar'
                ], 409);
            }
            
            $imageName = null;
            
            // Pastikan folder ada terlebih dahulu
            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Periksa apakah file valid
                if ($image->isValid()) {
                    $imageName = $image->hashName();
                    
                    // Gunakan pendekatan alternatif untuk menyimpan file
                    $image->move(storage_path('app/public/post'), $imageName);
                }
            }
            
            $user = UserModel::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'level_id' => $request->level_id,
                'nama' => $request->nama,
                'image' => $imageName
            ]);

            if($user) {
                return response()->json([
                    'success' => true,
                    'user' => $user,
                ], 201);
            } 
                
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat user'
            ], 409);
            
        } catch (QueryException $e) {
            // Cek apakah error adalah duplicate entry pada username
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username sudah terdaftar'
                ], 409);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Error database: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
