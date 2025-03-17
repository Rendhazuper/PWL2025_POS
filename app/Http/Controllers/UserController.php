<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrum = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'User']
        ];
        $page = (object)[
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user';
        $level = LevelModel::all();

        return view('user.index', [
            'breadcrumb' => $breadcrum,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'level' => $level
        ]);
    }
    public function tambah()
    {
        return view('user_tambah');
    }


    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username'=> $request->username,
            'nama'=> $request->nama,
            'password'=> Hash::make ('$request->password'),
            'level_id'=> $request->level_id,
        ]);
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::Find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = $request->password;
        $user->level_id = $request->level_id;

        $user -> save();
        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user -> delete();

        return redirect('/user');
    }
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama','level_id')
            ->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function($user){
                $btn = '<a href="'.url('/user/'.$user->user_id).'" class="btn btn-primary btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/user/'.$user->user_id.'/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/user/'.$user->user_id).'">'
                    .csrf_field().method_field('DELETE').
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah user',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah user baru'
        ];
        $level = LevelModel::all();
        $activeMenu = 'user';

        return view ('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'level' => $level]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'password' => 'required|min:5',
            'nama' => 'required|string|max:100',
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'nama' => $request->nama,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success','Data user berhasil disimpan');
    }

    public function show($id)
    {
        $breadcrumb = (object)[
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Data User'
        ];

        $user = UserModel::with('level')->findOrFail($id);
        $activeMenu = 'user';

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'user' => $user
        ]);
    }
    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel user kolom username kecuali untuk user dengan id yang sedang diedit
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'nullable|min:5', // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }


    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) { // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id); // Hapus data user

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
        ->with('level', $level);
    }
    public function update_ajax(Request $request, $id){
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id',
                'nama'      => 'required|max:100',
                'password'  => 'nullable|min:6|max:20'
            ];
            $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'meesage' => 'Validasi gagal,',
                'msgField' => $validator->errors()
            ]);
        }

        $check = UserModel::find($id);
        if($check){
            if(!$request->filled('password')){
                $request->request->remove('password');
        }

        $check->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate'
        ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
}
    public function store_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username',
                'nama' => 'required|max:100',
                'password' => 'required|min:6|max:20'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                UserModel::create([
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                    'nama' => $request->nama,
                    'level_id' => $request->level_id
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data'
                ]);
            }
        }

        return redirect('/');
    }
}



