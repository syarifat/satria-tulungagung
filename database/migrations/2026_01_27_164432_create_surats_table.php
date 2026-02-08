<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisasi_unit_id');
            $table->unsignedBigInteger('index_surat_id')->nullable();
            $table->string('nomor_surat', 100);
            $table->string('perihal', 255);
            $table->enum('jenis_surat', ['masuk', 'keluar']);
            
            $table->string('pengirim', 150)->nullable();
            $table->string('penerima', 150)->nullable();
            $table->string('kategori_surat', 50)->nullable();
            $table->date('tanggal_surat');
            $table->string('url_dokumen', 255)->nullable();
            
            // Approval
            $table->enum('status', ['draft', 'pending', 'diterima', 'ditolak'])->default('draft');
            $table->text('catatan_ditolak')->nullable();
            $table->unsignedBigInteger('diterima_oleh')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            
            $table->timestamps();

            // Constraints
            $table->foreign('organisasi_unit_id')->references('id')->on('organisasi_units');
            $table->foreign('index_surat_id')->references('id')->on('index_surats');
            $table->foreign('diterima_oleh')->references('id')->on('users');
            $table->foreign('dibuat_oleh')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('surats');
    }
};