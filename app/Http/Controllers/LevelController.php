<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index(){
      
        $breadcrumb = (object)[ 
            'title' => "Daftar level",
            'list' => ['Home', 'level']
        ]; 
        $page = (object)[
            'title' => "Level yang ada dalam sistem"
        ];

        $activeMenu = 'level';

        return view('level.index', ['page' => $page, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request){
        $levels = LevelModel::get();


        return DataTables::of($levels)
        ->addIndexColumn()
        ->addColumn('aksi', function ($level) {
            $btn  = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
                . csrf_field() . method_field('DELETE') .
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button>'
                . '</form>';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}

}
