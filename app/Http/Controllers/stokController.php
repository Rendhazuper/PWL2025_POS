<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use App\Models\stokModel;
use App\Models\supplierModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[ 
            'title' => "Stok",
            'list' => ['Home', 'stok']
        ]; 
        $page = (object)[
            'title' => "Stok"
        ];

        $activeMenu = 'stok';

        $barang = BarangModel::all();
        $supplier= supplierModel::all();

        return view('stok.index', ['page' => $page, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'barang' => $barang, 'supplier' => $supplier]);
    }

    public function list()
    {
        $stok = stokModel::select(['supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah'])
        ->with('supplier','barang','user');


        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('aksi', function($row){
                return '
                    <a href="'.url("stok/$row->stok_id").'" class="btn btn-sm btn-info">Lihat</a>
                    <a href="'.url("stok/$row->stok_id/edit").'" class="btn btn-sm btn-warning">Edit</a>
                    <a href="'.url("stok/$row->stok_id/delete").'" class="btn btn-sm btn-danger">Hapus</a>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
{
    $barang = BarangModel::all();
    $supplier = supplierModel::all();// ambil data barang untuk dropdown

    return view('stok.create', ['barang' => $barang, 'supplier' => $supplier] );
}

public function store(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'supplier_id' => 'required|exists:m_supplier,supplier_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'stok_jumlah' => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        stokModel::create([
            'supplier_id' => $request->supplier_id,
            'barang_id' => $request->barang_id,
            'stok_jumlah' => $request->stok_jumlah,
            'stok_tanggal' => now(), // ini penting
            'user_id' => 2,// ini penting!
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data stok berhasil disimpan'
        ]);
    }

    return redirect('/stok');
}
}
