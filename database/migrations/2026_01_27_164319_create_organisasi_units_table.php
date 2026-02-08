<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('organisasi_units', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->enum('level', ['pc', 'pac', 'pr']);
            
            // Parent ID (Self Referencing)
            $table->unsignedBigInteger('parent_id')->nullable();
            
            // Wilayah (Nullable karena PC tidak punya kecamatan/desa spesifik)
            $table->char('kecamatan_id', 6)->nullable();
            $table->char('desa_id', 10)->nullable();
            
            $table->text('alamat_sekretariat')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('notelp', 20)->nullable();
            $table->timestamps();

            // Constraints
            $table->foreign('parent_id')->references('id')->on('organisasi_units')->onDelete('set null');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans');
            $table->foreign('desa_id')->references('id')->on('desas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('organisasi_units');
    }
};