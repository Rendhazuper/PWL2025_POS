<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetail extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $counter = 1;
        
        for ($i = 1; $i <= 10; $i++) { // 10 transaksi
            for ($j = 1; $j <= 3; $j++) { // 3 barang per transaksi
                $barang_id = rand(1, 15);
                $data[] = [
                    'detail_id' => $counter,
                    'penjualan_id' => $i,
                    'barang_id' => $barang_id,
                    'harga' => rand(5000, 1000000),
                    'jumlah' => rand(1, 5),
                ];
                $counter++;
            }
        }
        DB::table('t_penjualan_detail')->insert($data);
    }
}
