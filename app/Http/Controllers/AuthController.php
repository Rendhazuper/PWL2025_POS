<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(){
        if(Auth::check()){
            return redirect('/');
        }
        return view('auth.login');
    }

    public function register(){
        $levels = LevelModel::select('level_id', 'level_nama')-> get();

        return view('auth.register')
        ->with('levels',$levels);
    }

    public function store(Request $request){
        if($request->ajax () || $request->wantsJson()){
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username',
                'nama' => 'required|max:100',
                'password' => 'required|min:2|max:20'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan',
                'redirect' => url('/user')
            ]);
        }
        return redirect('/user');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()){
        $credentials = $request->only('username', 'password');
            
        if(Auth::attempt($credentials)){
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'redirect'=> url('/')
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials'
        ]);
     }
       return redirect('login');
    }

    public function logout(Request $request){
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

}
