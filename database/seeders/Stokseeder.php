<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Stokseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'stok_id' => $i,
                'supplier_id' => ceil($i/5), 
                'barang_id' => $i,
                'user_id' => 1,
                'stok_tanggal' => '2024-01-01 10:00:00',
                'stok_jumlah' => 100,
            ];
        }
        DB::table('t_stok')->insert($data);
    }
}
