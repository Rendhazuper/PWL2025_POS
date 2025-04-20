<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function insert(){

    DB::table('m_barang')->insert([
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'BRG001',
                'barang_nama' => 'Biskuat',
                'harga_beli' => 3000,
                'harga_jual' => 4000
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 2,
                'barang_kode' => 'BRG002',
                'barang_nama' => 'Tango',
                'harga_beli' => 5000,
                'harga_jual' => 6000
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 3,
                'barang_kode' => 'BRG003',
                'barang_nama' => 'Oreo',
                'harga_beli' => 5000,
                'harga_jual' => 8000
            ]
        ]);
}

public function index(){
    
    $breadcrumb = (object)[
        'title' => "Daftar Barang",
        'list' => ['Home', 'Barang']
    ];

    $page = (object)[
        'title' => "Daftar barang yang ada dalam sistem"
    ];

    $activeMenu = 'barang';

    $kategori = KategoriModel::all();

    return view('barang.index', ['kategori'=> $kategori ,'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
} 
public function list(Request $request)
{
    $barang = BarangModel::with('kategori')
    ->get();


    // if ($request->level_id){
    //     $users->where('level_id', $request->level_id);
    // }
    
    return DataTables::of($barang)
        // Menambahkan kolom index / no urut (default: DT_RowIndex)
        ->addIndexColumn()
        // Menambahkan kolom aksi (tombol detail, edit, hapus)
        ->addColumn('aksi', function ($barang) {
            $btn  = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">'
                . csrf_field() . method_field('DELETE') .
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button>'
                . '</form>';
            return $btn;
        })

        // Memberitahu bahwa kolom 'aksi' mengandung HTML
        ->rawColumns(['aksi'])
        ->make(true);
}

}
