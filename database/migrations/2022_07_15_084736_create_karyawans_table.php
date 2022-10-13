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
        Schema::create('t_karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nik_karyawan')->unique();
            $table->foreignId('bagian_id');
            $table->string('nama_karyawan');
            $table->integer('tarif_lembur');
            $table->char('status_kontrak');
            $table->string('update_by');
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
        Schema::dropIfExists('t_karyawan');
    }
};
