<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokTable extends Migration
{
    public function up()
    {
        Schema::create('stok', function (Blueprint $table) {
            $table->id('stok_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah_stok')->default(0);
            $table->timestamps();

            $table->foreign('barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok');
    }
}
