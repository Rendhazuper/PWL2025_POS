<?php

namespace App\Http\Controllers;

use App\Models\supplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class supplierController extends Controller
{
    public function insert(){
        DB::table('m_supplier')->insert([
            ['supplier_id' => 1, 'supplier_kode' => 'SUP1', 'supplier_nama' => 'Supplier 1', 'supplier_alamat' => 'Alamat 1'],
            ['supplier_id' => 2, 'supplier_kode' => 'SUP2', 'supplier_nama' => 'Supplier 2', 'supplier_alamat' => 'Alamat 2'],
            ['supplier_id' => 3, 'supplier_kode' => 'SUP3', 'supplier_nama' => 'Supplier 3', 'supplier_alamat' => 'Alamat 3'],
        ]);
    }
    public function index(){
        $breadcrumb = (object)[ 
            'title' => "Daftar Supplier",
            'list' => ['Home', 'supplier']
        ]; 
        $page = (object)[
            'title' => "Supplier yang terdaftar"
        ];

        $activeMenu = 'supplier';

        return view('supllier.index', ['page' => $page, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    } 

    public function list(Request $request){
        $supplier = supplierModel::get();

        return DataTables::of($supplier)
        ->addIndexColumn()
        ->addColumn('aksi', function ($supplier) {
            $btn  = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">'
                . csrf_field() . method_field('DELETE') .
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button>'
                . '</form>';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
}
