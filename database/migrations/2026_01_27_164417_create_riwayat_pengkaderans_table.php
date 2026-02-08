<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('riwayat_pengkaderans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggota_id');
            $table->enum('jenis_pengkaderan', ['PKD', 'PKL', 'PKN', 'Diklatsar', 'Susbalan', 'Susbanpim', 'Dirosah']);
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->string('pelaksana', 150)->nullable();
            $table->string('nomor_sertifikat', 100)->nullable();
            $table->string('url_dokumen', 255)->nullable();
            $table->timestamps();

            $table->foreign('anggota_id')->references('id')->on('anggotas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_pengkaderans');
    }
};