<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailPenjualanModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan_detail';
    protected $primaryKey ='detail_id';
    public $fillable = [
        'penjualan_id',
        'barang_id',
        'harga',
        'jumlah'
    ];

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }
}
