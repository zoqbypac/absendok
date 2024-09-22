<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absen_kirim', function (Blueprint $table) {
            $table->id();
            $table->integer('absenid')->unique();
            $table->date('tanggal');
            $table->boolean('kirim')->default(false);
            $table->string('status')->nullable();
            $table->boolean('eksklusi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_kirim');
    }
};
