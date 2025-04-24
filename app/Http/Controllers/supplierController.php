<?php

namespace App\Http\Controllers;

use App\Models\supplierModel;
use Illuminate\Support\Facades\Validator;
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
                $btn  = '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id .'/show').'\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id .'/edit').'\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id .'/delete').'\')" class="btn btn-danger btn-sm">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create(){
        return view('supllier.create');
    }

    public function store(Request $request){
        if($request->ajax () || $request->wantsJson()){
            $rules = [
                'supplier_kode' => 'required|max:20|unique:m_supplier,supplier_kode',
                'supplier_nama' => 'required|max:20',
                'supplier_alamat' => 'required|max:25',
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            supplierModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }   
    public function edit(string $id){
        $supplier= supplierModel::find($id);

        return view('supllier.edit', ['supplier' => $supplier]);
    }
    public function update(Request $request, $id)
    {
        if($request->ajax()|| $request->wantsJson()){
            $rules = [
              'supplier_kode' => 'required|max:20|unique:m_supplier,supplier_kode',
                'supplier_nama' => 'required|max:20',
                'supplier_alamat' => 'required|max:25',
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $check = supplierModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/supplier');
    }
    public function confirm(string $id){
        $supplier = supplierModel::find($id);
        return view('supllier.confirm',['supplier' => $supplier]);
    }
    public function delete(Request $request, $id){
        if($request->ajax()|| $request->wantsJson()){
            $supplier = supplierModel::find($id);
            if($supplier ){
                $supplier->delete();
                return response()->json([
                    'status' => true,
                    'message'=> 'Data berhasil dihapus',
                    'redirect' => url('/supplier')
                ]);
            } else {
                return response()->json([
                    'status'=> false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/supplier'); 
    }    
    

}
