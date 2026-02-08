<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisasi_unit_id');
            $table->string('nama', 255);
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->string('lokasi', 255);
            
            $table->enum('status', ['permintaan', 'diterima', 'ditolak', 'selesai'])->default('permintaan');
            $table->text('catatan_ditolak')->nullable();
            
            $table->timestamps();

            $table->foreign('organisasi_unit_id')->references('id')->on('organisasi_units')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agendas');
    }
};