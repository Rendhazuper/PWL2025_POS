<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\detailPenjualanModel;
use App\Models\penjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;
use App\Http\Controllers\Str;
use Illuminate\Http\Request;
use Nette\Utils\Random;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{
    public function index(){
        $breadcrumb = (object)[ 
            'title' => "Transaksi",
            'list' => ['Home', 'transaksi']
        ]; 
        $page = (object)[
            'title' => "transaksi"
        ];

        $activeMenu = 'transaksi';
        $barang = BarangModel::with('stok')->get();
        $kasir = UserModel::all();$rekap = penjualanModel::select(['penjualan_id', 'user_id', 'pembeli', 'penjualan_tanggal'])
        ->with(['user', 'detailPenjualan'])
        ->orderBy('penjualan_tanggal', 'desc')
        ->get();
        // dd($rekap);
        // $stok = StokModel::all(): 


        return view('transaksi.index', ['page' => $page, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'barang' => $barang, 'kasir' => $kasir, 'rekap' => $rekap]);    
    }


    public function create()
    {
        $barang = BarangModel::all();
        return view('transaksi.create', ['barang' => $barang]);
    }

    public function list()
    {
        $penjualan = penjualanModel::select(['penjualan_id', 'user_id', 'pembeli', 'penjualan_tanggal'])
            ->with(['user', 'detailPenjualan.barang']);
    
        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('kasir', function ($row) {
                return $row->user->nama ?? '-'; // Ambil nama kasir dari relasi user
            })
            ->addColumn('pembeli', function ($row) {
                return $row->pembeli; // Nama pembeli langsung dari kolom pembeli
            })
            ->addColumn('barang', function ($row) {
                $barang = $row->detailPenjualan->map(function ($detail) {
                    return $detail->barang->barang_nama ?? '-'; // Ambil nama barang dari relasi barang
                })->join(', '); // Gabungkan nama barang jika ada lebih dari satu
                return $barang;
            })
            ->addColumn('jumlah', function ($row) {
                $jumlah = $row->detailPenjualan->sum('jumlah'); // Total jumlah dari detail penjualan
                return $jumlah;
            })
            ->addColumn('nominal', function ($row) {
                $nominal = $row->detailPenjualan->sum(function ($detail) {
                    return $detail->harga * $detail->jumlah; // Hitung nominal (harga * jumlah)
                });
                return number_format($nominal, 2); // Format nominal dengan 2 desimal
            })
            ->addColumn('tanggal', function ($row) {
                return $row->penjualan_tanggal->format('Y-m-d'); // Format tanggal
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="'.url("transaksi/$row->penjualan_id").'" class="btn btn-sm btn-info">Lihat</a>
                    <a href="'.url("transaksi/$row->penjualan_id/edit").'" class="btn btn-sm btn-warning">Edit</a>
                    <a href="'.url("transaksi/$row->penjualan_id/delete").'" class="btn btn-sm btn-danger">Hapus</a>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kasir_id' => 'required',
        'pembeli' => 'required',
        'barang_id' => 'required|array',
        'jumlah' => 'required|array',
    ]);

    // Simpan data ke tabel t_penjualan
    $penjualan = penjualanModel::create([
        'user_id' => $request->kasir_id,
        'pembeli' => $request->pembeli,
        'penjualan_kode' => 123, // Random kode
        'penjualan_tanggal' => now(),
    ]);

    // Simpan data ke tabel t_penjualan_detail
    foreach ($request->barang_id as $index => $barang_id) {
        detailPenjualanModel::create([
            'penjualan_id' => $penjualan->penjualan_id,
            'barang_id' => $barang_id,
            'harga' => BarangModel::find($barang_id)->harga_jual, // Ambil harga dari tabel barang
            'jumlah' => $request->jumlah[$index],
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Transaksi berhasil disimpan.',
    ]);
}


    
}

