<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->unique();
            $table->unsignedBigInteger('organisasi_unit_id'); // Wajib
            $table->unsignedBigInteger('jabatan_id')->nullable();
            
            // Biodata
            $table->string('nik', 16)->unique();
            $table->string('nia_ansor', 20)->nullable()->unique();
            $table->string('nama', 150);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('kelamin', ['L', 'P']);
            $table->enum('status_kawin', ['belum_kawin', 'kawin', 'cerai_hidup', 'cerai_mati'])->nullable();
            $table->string('notelp', 20)->nullable();
            $table->string('url_foto', 255)->nullable();
            
            // Alamat Domisili
            $table->text('alamat')->nullable();
            $table->char('kecamatan_id', 6)->nullable();
            $table->char('desa_id', 10)->nullable();
            
            // Info Lain
            $table->string('last_education', 50)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->text('job_address')->nullable();
            
            $table->timestamps();

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('organisasi_unit_id')->references('id')->on('organisasi_units'); // Tidak cascade agar data aman
            $table->foreign('jabatan_id')->references('id')->on('jabatans');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans');
            $table->foreign('desa_id')->references('id')->on('desas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggotas');
    }
};