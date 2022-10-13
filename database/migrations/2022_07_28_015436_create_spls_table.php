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
        Schema::create('t_spl', function (Blueprint $table) {
            $table->id();
            $table->string('id_spl');
            $table->string('id_jenis_hari');
            $table->string('kode_proyek');
            $table->string('nama_proyek');
            $table->text('keterangan')->nullable(false);
            $table->dateTime('tgl_lembur'); //Start date
            $table->dateTime('end_date');
            $table->time('start_jam');
            $table->time('end_jam');
            $table->double('istirahat');
            $table->date('tgl_pengajuan');
            $table->string('updated_by');
            $table->string('nama_bagian');
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
        Schema::dropIfExists('t_spl');
    }
};
