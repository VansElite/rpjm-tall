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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_program');
            $table->foreign('id_program')->references('id')->on('program');
            $table->string('nama');
            $table->string('status');
            $table->string('volume');
            $table->string('satuan');
            $table->boolean('tahun_1');
            $table->boolean('tahun_2');
            $table->boolean('tahun_3');
            $table->boolean('tahun_4');
            $table->boolean('tahun_5');
            $table->boolean('tahun_6');
            $table->string('lokasi');
            $table->unsignedBigInteger('id_dusun');
            $table->foreign('id_dusun')->references('id')->on('dusun');
            $table->string('longitude');
            $table->string('latitude');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
