<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrum = (object)[
            'title' => 'Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object)[
            'title' => 'Daftar Level Pengguna'
        ];

        $activeMenu = 'level';

        return view('level.index', [
            'breadcrumb' => $breadcrum,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function($level){
                $btn = '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/confirm_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Level Baru'
        ];

        $activeMenu = 'level';

        return view('level.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    public function show($id)
    {
        $breadcrumb = (object)[
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Data Level'
        ];

        $level = LevelModel::findOrFail($id);
        $activeMenu = 'level';

        return view('level.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'level' => $level
        ]);
    }

    public function edit($id)
    {
        $breadcrumb = (object)[
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Data Level'
        ];

        $level = LevelModel::find($id);
        $activeMenu = 'level';

        return view('level.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'level' => $level
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode,'.$id.',level_id',
            'level_nama' => 'required|string|max:100'
        ]);

        $level = LevelModel::find($id);
        $level->level_kode = $request->level_kode;
        $level->level_nama = $request->level_nama;
        $level->save();

        return redirect('/level')->with('success', 'Data level berhasil diperbarui');
    }

    public function destroy($id)
    {
        try {
            LevelModel::destroy($id);
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100'
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
                LevelModel::create([
                    'level_kode' => $request->level_kode,
                    'level_nama' => $request->level_nama
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

    public function edit_ajax($id)
    {
        $level = LevelModel::find($id);
        return view('level.edit_ajax', ['level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode,'.$id.',level_id',
                'level_nama' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = LevelModel::find($id);
            if($check){
                try {
                    $check->update($request->all());
                    alert()->success('Berhasil','Data berhasil diupdate');
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diupdate'
                    ]);
                } catch (\Exception $e) {
                    alert()->error('Error','Gagal mengupdate data');
                    return response()->json([
                        'status' => false,
                        'message' => 'Gagal mengupdate data'
                    ]);
                }
            } else {
                alert()->error('Error','Data tidak ditemukan');
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Invalid request'
        ]);
    }

    public function confirm_ajax($id)
    {
        if (request()->ajax() || request()->wantsJson()) {
            $level = LevelModel::find($id);
            return view('level.confirm_ajax', compact('level'));
        }
        return response()->json([
            'status' => false,
            'message' => 'Invalid request'
        ]);
    }

    public function delete_ajax($id)
    {
        if (request()->ajax() || request()->wantsJson()) {
            try {
                $level = LevelModel::findOrFail($id);

                // Check if level has related users
                $userCount = DB::table('m_user')->where('level_id', $id)->count();

                if ($userCount > 0) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Level tidak dapat dihapus karena masih digunakan oleh ' . $userCount . ' pengguna. Harap hapus atau ubah level pengguna terkait terlebih dahulu.'
                    ]);
                }

                $level->delete();
                Alert::success('Berhasil', 'Data berhasil dihapus');

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                    'redirect' => url('/level')
                ]);
            } catch (\Exception $e) {
                Alert::error('Error', 'Gagal menghapus data');
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data'
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid request'
        ]);
    }
}
