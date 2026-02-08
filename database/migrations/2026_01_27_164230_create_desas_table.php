<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('desas', function (Blueprint $table) {
            $table->char('id', 10)->primary(); // Contoh: '3504012001'
            $table->char('kecamatan_id', 6);
            $table->string('nama', 100);
            $table->timestamps();

            // Foreign Key
            $table->foreign('kecamatan_id')
                  ->references('id')->on('kecamatans')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('desas');
    }
};