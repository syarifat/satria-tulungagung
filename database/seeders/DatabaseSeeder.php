<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * * @return void
     */
    public function run(): void
    {
        // Opsional: Matikan foreign key check untuk memastikan pembersihan data lama lancar
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            // 1. Isi Data Wilayah (Kecamatan & Desa Tulungagung)
            WilayahTulungagungSeeder::class,

            // 2. Isi Data Master (Jabatan & Index Surat)
            MasterDataSeeder::class,

            // 3. Isi Struktur Organisasi (PC, 19 PAC, 271 PR) & 1.455 Anggota
            OrganisasiDanAnggotaSeeder::class,

            // 4. Isi Contoh Transaksi (Agenda & Surat) untuk Testing
            TransaksiSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('-----------------------------------------------');
        $this->command->info(' SEEDING BERHASIL SELESAI! ');
        $this->command->info(' Total Organisasi: 291 Unit ');
        $this->command->info(' Total Anggota   : 1.455 Orang ');
        $this->command->info('-----------------------------------------------');
    }
}