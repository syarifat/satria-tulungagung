<?php

namespace Database\Seeders;

use App\Models\OrganisasiUnit;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganisasiUnitOnlySeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama unit organisasi
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        OrganisasiUnit::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // BUAT UNIT PC (Pusat Cabang)
        $pc = OrganisasiUnit::create([
            'nama' => 'PC GP Ansor Tulungagung',
            'level' => 'pc',
            'parent_id' => null,
            'kecamatan_id' => null,
            'desa_id' => null,
            'alamat_sekretariat' => 'Jl. KH. Abdul Fattah No. 12, Tulungagung',
            'email' => 'pc.tulungagung@ansor.or.id',
            'notelp' => '0355321000',
        ]);

        // BUAT PAC (Pimpinan Anak Cabang) per Kecamatan
        $kecamatans = Kecamatan::all();

        foreach ($kecamatans as $kec) {
            $pac = OrganisasiUnit::create([
                'nama' => 'PAC GP Ansor ' . $kec->nama,
                'level' => 'pac',
                'parent_id' => $pc->id,
                'kecamatan_id' => $kec->id,
                'desa_id' => null,
                'alamat_sekretariat' => null, // Biarkan kosong, diisi admin nanti
                'email' => null,              // Biarkan kosong, diisi admin nanti
                'notelp' => null,             // Biarkan kosong, diisi admin nanti
            ]);

            // BUAT PR (Pimpinan Ranting) per Desa
            $desas = Desa::where('kecamatan_id', $kec->id)->get();

            foreach ($desas as $desa) {
                OrganisasiUnit::create([
                    'nama' => 'PR GP Ansor ' . $desa->nama,
                    'level' => 'pr',
                    'parent_id' => $pac->id,
                    'kecamatan_id' => $kec->id,
                    'desa_id' => $desa->id,
                    'alamat_sekretariat' => null, // Biarkan kosong, diisi admin nanti
                    'email' => null,              // Biarkan kosong, diisi admin nanti
                    'notelp' => null,             // Biarkan kosong, diisi admin nanti
                ]);
            }
        }

        $this->command->info('Unit Organisasi berhasil di-seed! (PC, PAC, PR)');
    }
}
