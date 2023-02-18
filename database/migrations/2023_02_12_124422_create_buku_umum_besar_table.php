<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuUmumBesarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku_umum_besar', function (Blueprint $table) {
            $table->id();
            $table->char('uraian', 100);
            $table->json('data')->nullable();
            $table->date('tanggal');
            $table->char('nomor_bukti', 100);
            $table->char('nomor_rekening', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku_umum_besar');
    }
}
