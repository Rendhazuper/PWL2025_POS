<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'penjualan_id' => $i,
                'user_id' => 3,
                'pembeli' => 'Customer ' . $i,
                'penjualan_kode' => 'PJ' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'penjualan_tanggal' => '2024-01-' . str_pad($i, 2, '0', STR_PAD_LEFT) . ' 08:00:00',
            ];
        }
        DB::table('t_penjualan')->insert($data);
    }
}
