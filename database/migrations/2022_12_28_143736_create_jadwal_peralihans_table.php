<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_peralihan', function (Blueprint $table) {
            $table->id('jadwalid');
            $table->date('tanggal');
            $table->string('kodedokter');
            $table->string('namadokter');
            $table->string('poliklinik');
            $table->string('hari');
            $table->string('waktu');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
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
        Schema::dropIfExists('jadwal_peralihan');
    }
};
