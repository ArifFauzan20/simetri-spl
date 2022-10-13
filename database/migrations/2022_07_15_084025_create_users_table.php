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
        Schema::create('t_user_login', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id');
            $table->string('nik_karyawan')->unique();
            $table->enum('status_user', [0, 1]);
            $table->string('password');
            $table->foreignId('role_id');
            $table->dateTime('last_login')->nullable()->default(null);
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
        Schema::dropIfExists('t_user_login');
    }
};
