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
        Schema::create('t_detail_spl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spl_id')->nullOnDelete();
            $table->foreignId('karyawan_id');
            $table->string('lama_lembur');
            $table->string('uang_makan');
            $table->string('poin_lembur');
            $table->string('tarif_total_lembur');
            $table->string('updated_by');
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
        Schema::dropIfExists('t_detail_spl');
    }
};
