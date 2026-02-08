<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\IndexSurat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama agar tidak duplikat saat seeding ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Jabatan::truncate();
        IndexSurat::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- SEED JABATAN ---
        // Penentuan level_akses agar saat input anggota PAC, 
        // jabatan 'Kasatkorcab' (level PC) tidak muncul.
        $jabatans = [
            ['nama' => 'Ketua', 'level_akses' => 'all'],
            ['nama' => 'Wakil Ketua', 'level_akses' => 'all'],
            ['nama' => 'Sekretaris', 'level_akses' => 'all'],
            ['nama' => 'Wakil Sekretaris', 'level_akses' => 'all'],
            ['nama' => 'Bendahara', 'level_akses' => 'all'],
            ['nama' => 'Wakil Bendahara', 'level_akses' => 'all'],
            ['nama' => 'Kasatkorcab', 'level_akses' => 'pc'],
            ['nama' => 'Kasatkoryon', 'level_akses' => 'pac'],
            ['nama' => 'Kasatkorpok', 'level_akses' => 'pr'],
            ['nama' => 'Anggota', 'level_akses' => 'all'],
        ];

        foreach ($jabatans as $jabatan) {
            Jabatan::create($jabatan);
        }

        // --- SEED INDEX SURAT ---
        // Mengikuti standar administrasi organisasi (contoh umum)
        $indexes = [
            ['kode' => 'A-I', 'deskripsi' => 'Surat Keputusan (SK)'],
            ['kode' => 'A-II', 'deskripsi' => 'Surat Mandat'],
            ['kode' => 'B-I', 'deskripsi' => 'Surat Undangan Intern'],
            ['kode' => 'B-II', 'deskripsi' => 'Surat Undangan Ekstern'],
            ['kode' => 'C-I', 'deskripsi' => 'Surat Permohonan'],
            ['kode' => 'C-II', 'deskripsi' => 'Surat Keterangan'],
            ['kode' => 'D-I', 'deskripsi' => 'Surat Tugas'],
            ['kode' => 'E-I', 'deskripsi' => 'Surat Instruksi'],
        ];

        foreach ($indexes as $index) {
            IndexSurat::create($index);
        }

        $this->command->info('Master Jabatan dan Index Surat berhasil di-seed!');
    }
}