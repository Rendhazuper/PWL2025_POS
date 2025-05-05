<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'barang_kode' => 'required',
            'barang_nama' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        }

        try {
            // Cek apakah barang_kode sudah ada di database
            $existingBarang = BarangModel::where('barang_kode', $request->barang_kode)->first();
            
            if ($existingBarang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barang sudah terdaftar'
                ], 409);
            }
            
            $imageName = null;
            
            // Pastikan folder ada terlebih dahulu
            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Periksa apakah file valid
                if ($image->isValid()) {
                    $imageName = $image->hashName();
                    
                    // Gunakan pendekatan alternatif untuk menyimpan file
                    $image->move(storage_path('app/public/post'), $imageName);
                }
            }

            $barang = BarangModel::create([
                'kategori_id' => $request->kategori_id,
                'barang_kode' => $request->barang_kode,
                'barang_nama' => $request->barang_nama,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'image' => $imageName
            ]);

            if($barang) {
                return response()->json([
                    'success' => true,
                    'kategori' => $barang,
                ], 201);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data barang'
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }

    public function update(Request $request, BarangModel $barang)
    {
      
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
        
            if ($barang->image && Storage::disk('public')->exists('post/' . $barang->image)) {
                Storage::disk('public')->delete('post/' . $barang->image);
            }

            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('public/post', $imageName);
            $request->merge(['image' => $imageName]);
        }

        $barang->update($request->all());
        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    public function destroy(BarangModel $barang)
    {
        // Hapus gambar jika ada
        if ($barang->image && Storage::disk('public')->exists('post/' . $barang->image)) {
            Storage::disk('public')->delete('post/' . $barang->image);
        }
     
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil terhapus'
        ]);
    }
}
