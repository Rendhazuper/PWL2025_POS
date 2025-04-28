<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public function profile($id)
    {
        $breadcrumb = (object)[
            'title' => 'Profil',
            'list' => ['Home', 'Profil']
        ];
        $activeMenu = 'profile';
        $user = UserModel::findOrFail($id);
        return view('auth.profile', compact('breadcrumb',  'user', 'activeMenu'));
    }

    public function edit($id)
    {
        $breadcrumb = (object)[
            'title' => 'Edit Profil',
            'list' => ['Home', 'Profil', 'Edit Profil']
        ];
        $activeMenu = 'profile';
        $user = UserModel::findOrFail($id);

        return view('auth.edit_profile', compact('breadcrumb', 'user', 'active_menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'username' => 'required|min:3|max:20',
            'password' => 'nullable|min:6|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = UserModel::findOrFail($id);
        if (UserModel::where('username', $request->username)->where('user_id', '!=', $id)->exists()) {
            return redirect()->back()->withErrors(['username' => 'Username telah digunakan']);
        } else {
            $user->username = $request->username;
        }
        $user->nama = $request->nama;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');

            // Debugging: Periksa apakah file diterima
            if (!$image->isValid()) {
                Log::error('File tidak valid: ' . $image->getErrorMessage());
                return redirect()->back()->withErrors(['profile_image' => 'File tidak valid']);
            }

            // Proses file
            $imageContent = file_get_contents($image->getRealPath());
            $base64Image = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . base64_encode($imageContent);
            $user->profile_image = $base64Image;
        } else {
            Log::error('File tidak ditemukan dalam request');
            return redirect()->back()->withErrors(['profile_image' => 'File tidak ditemukan']);
        }
        $user->updated_at = now()->timezone('Asia/Jakarta');
        $user->save();

        return redirect("/profile/{$id}")->with('success', 'Profile updated successfully!');
    }

}
