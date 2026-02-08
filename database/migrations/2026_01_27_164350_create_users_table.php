<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 100); // Pastikan ini 'nama', bukan 'name'
        $table->string('email', 100)->unique();
        $table->string('password');
        $table->unsignedBigInteger('organisasi_unit_id')->nullable();
        $table->enum('role', ['super_admin', 'admin_pc', 'admin_pac', 'admin_pr', 'anggota'])->default('anggota');
        $table->boolean('is_active')->default(true);
        $table->timestamps();

        $table->foreign('organisasi_unit_id')->references('id')->on('organisasi_units')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
