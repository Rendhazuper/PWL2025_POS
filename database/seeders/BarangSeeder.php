<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Supplier 1 - Elektronik & Pakaian
            ['barang_id' => 1, 'kategori_id' => 1,  'barang_kode' => 'BRG001', 'barang_nama' => 'Laptop', 'harga_beli' => 8000000, 'harga_jual' => 9000000],
            ['barang_id' => 2, 'kategori_id' => 1,  'barang_kode' => 'BRG002', 'barang_nama' => 'Smartphone', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['barang_id' => 3, 'kategori_id' => 1,  'barang_kode' => 'BRG003', 'barang_nama' => 'Tablet', 'harga_beli' => 4000000, 'harga_jual' => 4500000],
            ['barang_id' => 4, 'kategori_id' => 2,  'barang_kode' => 'BRG004', 'barang_nama' => 'Kemeja', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['barang_id' => 5, 'kategori_id' => 2,  'barang_kode' => 'BRG005', 'barang_nama' => 'Celana', 'harga_beli' => 200000, 'harga_jual' => 250000],

            // Supplier 2 - Makanan & Minuman
            ['barang_id' => 6, 'kategori_id' => 3,  'barang_kode' => 'BRG006', 'barang_nama' => 'Biskuit', 'harga_beli' => 8000, 'harga_jual' => 10000],
            ['barang_id' => 7, 'kategori_id' => 3,  'barang_kode' => 'BRG007', 'barang_nama' => 'Coklat', 'harga_beli' => 12000, 'harga_jual' => 15000],
            ['barang_id' => 8, 'kategori_id' => 3,  'barang_kode' => 'BRG008', 'barang_nama' => 'Keripik', 'harga_beli' => 8000, 'harga_jual' => 10000],
            ['barang_id' => 9, 'kategori_id' => 4,  'barang_kode' => 'BRG009', 'barang_nama' => 'Soda', 'harga_beli' => 4000, 'harga_jual' => 6000],
            ['barang_id' => 10, 'kategori_id' => 4,  'barang_kode' => 'BRG010', 'barang_nama' => 'Jus', 'harga_beli' => 5000, 'harga_jual' => 8000],

            // Supplier 3 - Peralatan Rumah
            ['barang_id' => 11, 'kategori_id' => 5,  'barang_kode' => 'BRG011', 'barang_nama' => 'Panci', 'harga_beli' => 80000, 'harga_jual' => 100000],
            ['barang_id' => 12, 'kategori_id' => 5,  'barang_kode' => 'BRG012', 'barang_nama' => 'Wajan', 'harga_beli' => 60000, 'harga_jual' => 80000],
            ['barang_id' => 13, 'kategori_id' => 5,  'barang_kode' => 'BRG013', 'barang_nama' => 'Sendok Set', 'harga_beli' => 40000, 'harga_jual' => 55000],
            ['barang_id' => 14, 'kategori_id' => 5,  'barang_kode' => 'BRG014', 'barang_nama' => 'Piring Set', 'harga_beli' => 100000, 'harga_jual' => 130000],
            ['barang_id' => 15, 'kategori_id' => 5,  'barang_kode' => 'BRG015', 'barang_nama' => 'Gelas Set', 'harga_beli' => 50000, 'harga_jual' => 70000],
        ];
        DB::table('m_barang')->insert($data);
    }
}
