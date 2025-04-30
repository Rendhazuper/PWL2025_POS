<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function __invoke(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori_models,id',
            'barang_kode' => 'required|unique:barang_models,barang_kode',
            'barang_nama' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);
        
        if($validator->fails())
        {
            return response()->json($validator->errors(), 422); 
        }

        $barang = BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);
        if($barang) {
            return response()->json([
                'success' => true,
                'kategori' => $barang,
            ], 201);
        }
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }

    public function update(Request $request, BarangModel $barang)
    {
        $barang->update($request->all());
        return BarangModel::find($barang);
    }

    public function destroy(BarangModel $barang)
    {
     
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil terhapus'
        ]);
    }
}
