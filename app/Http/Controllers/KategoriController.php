<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function insert(){
    DB::table('m_kategori')->insert([
    [
        'kategori_id' => 1,
        'kategori_kode' => 'KODE1',
        'kategori_nama' => 'Nama Kategori 1'
    ],
    [
        'kategori_id' => 2,
        'kategori_kode' => 'KODE2',
        'kategori_nama' => 'Nama Kategori 2'
    ],
    [
        'kategori_id' => 3,
        'kategori_kode' => 'KODE3',
        'kategori_nama' => 'Nama Kategori 3'
    ]
]);

    }
    public function index(){
      
        $breadcrumb = (object)[ 
            'title' => "Daftar Kategori",
            'list' => ['Home', 'Kategori']
        ]; 
        $page = (object)[
            'title' => "Kategori yang ada dalam sistem"
        ];

        $activeMenu = 'kategori';

        return view('kategori.index', ['page' => $page, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    } 
    public function list(Request $request){
        $kategori = KategoriModel::get();

        return DataTables::of($kategori)
        ->addIndexColumn()
        ->addColumn('aksi', function ($kategori) {
            $btn  = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                . csrf_field() . method_field('DELETE') .
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button>'
                . '</form>';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
}


