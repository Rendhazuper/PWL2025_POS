<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?,?,?)',['CUS','Pelanggan', now()]);

        // return 'Insert data baru berhasil';

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);

        // return 'Delete data berhasil, jumlah data yang dihapus : '.$row.' baris';

        $data = DB::select ('select * from m_level');
        return view('level', ['data'=> $data]);

    }
}
