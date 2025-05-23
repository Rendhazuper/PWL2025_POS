<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualanModel extends Model
{
    use HasFactory;

    protected $table = "t_penjualan";
    protected $primaryKey= "penjualan_id";
    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function detailPenjualan()
{
    return $this->hasMany(detailPenjualanModel::class, 'penjualan_id');
}
}
