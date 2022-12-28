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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('absenid');
            $table->integer('jadwalid');
            $table->date('tanggal');
            $table->string('kodedokter');
            $table->string('namadokter');
            $table->string('poliklinik');
            $table->string('hari');
            $table->string('waktu');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->integer('selisih_masuk')->nullable();
            $table->integer('selisih_pulang')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('absensi');
    }
};
