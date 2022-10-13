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
        Schema::create('t_approval', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spl_id');
            $table->enum('status', ['2', '3', '4', '5', '6']);
            $table->date('tgl_approval_spv')->nullable()->default(null);
            $table->date('tgl_approval_manager')->nullable()->default(null);
            $table->string('kode_proyek');
            $table->dateTime('tgl_pengajuan');
            $table->dateTime('end_date');
            $table->string('updated_by');
            $table->string('keterangan')->nullable()->default(null);
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
        Schema::dropIfExists('t_approval');
    }
};
