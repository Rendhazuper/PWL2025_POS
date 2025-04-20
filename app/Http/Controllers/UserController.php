<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(){
    
        $breadcrumb = (object)[
            'title' => "Daftar Pengguna",
            'list' => ['Home', 'Daftar Pengguna']
        ];

        $page = (object)[
            'title' => "Daftar user yang terdaftar dalam sistem"
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        return view('user.index', ['level'=> $level ,'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    } 

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        if ($request->level_id){
            $users->where('level_id', $request->level_id);
        }
        
    
        return DataTables::of($users)
            // Menambahkan kolom index / no urut (default: DT_RowIndex)
            ->addIndexColumn()
            // Menambahkan kolom aksi (tombol detail, edit, hapus)
            ->addColumn('aksi', function ($user) {
                $btn  = '<button onclick="modalAction(\''.url('/user/' . $user->user_id .'/show').'\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id .'/edit').'\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id .'/delete').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            // Memberitahu bahwa kolom 'aksi' mengandung HTML
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function create(){
        $level = LevelModel::select('level_id', 'level_nama')-> get();

        return view('user.create')
        ->with('level',$level);
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
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function edit(string $id){
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')-> get();

        return view('user.edit', ['user' => $user, 'level' =>$level]);
    }

    public function update(Request $request, $id)
    {
        if($request->ajax()|| $request->wantsJson()){
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,'.$id. ',user_id',
                'nama' => 'required|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $check = UserModel::find($id);
            if($check){
                if(!$request->filled('password')){
                    $request ->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                    'redirect' => url('/user')

                ]);
            }
        }
        return redirect('/user');

    }
    public function confirm(string $id){
        $user = UserModel::find($id);
        return view('user.confirm',['user' => $user]);
    }
    public function delete(Request $request, $id){
        if($request->ajax()|| $request->wantsJson()){
            $user = UserModel::find($id);
            if($user){
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message'=> 'Data berhasil dihapus',
                    'redirect' => url('/user')
                ]);
            } else {
                return response()->json([
                    'status'=> false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/user'); 
    }         
}