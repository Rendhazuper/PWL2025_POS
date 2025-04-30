<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return KategoriModel::all();
    }

    public function __invoke(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'kategori_kode' => 'required',
            'kategori_nama' => 'required',
        ]);
        
        if($validator->fails())
        {
            return response()->json($validator->errors(), 422); 
        }

        $kategori = KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);
        if($kategori) {
            return response()->json([
                'success' => true,
                'kategori' => $kategori,
            ], 201);
        }
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function show(KategoriModel $kategori)
    {
        return KategoriModel::find($kategori);
    }

    public function update(Request $request, KategoriModel $kategori)
    {
        $kategori->update($request->all());
        return KategoriModel::find($kategori);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriModel $kategori)
    {
     
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil terhapus'
        ]);
    }
}
