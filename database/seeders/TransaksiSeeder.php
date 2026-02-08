<?php

namespace Database\Seeders;

use App\Models\Surat;
use App\Models\Agenda;
use App\Models\User;
use App\Models\OrganisasiUnit;
use App\Models\IndexSurat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Surat::truncate();
        Agenda::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $adminPc = User::where('role', 'admin_pc')->first();
        $pcUnit = OrganisasiUnit::where('level', 'pc')->first();
        
        $indexSk = IndexSurat::where('kode', 'A-I')->first() ?? IndexSurat::first();
        $indexUndangan = IndexSurat::where('kode', 'B-I')->first() ?? IndexSurat::first();
        
        $allUnits = OrganisasiUnit::all();
        
        $this->command->info('Sedang mengisi transaksi surat & agenda...');

        foreach ($allUnits as $unit) {
            // --- SEED AGENDA (LENGKAP SEMUA FIELD) ---
            Agenda::create([
                'organisasi_unit_id' => $unit->id,
                'nama' => 'Rapat Rutin ' . $unit->nama,
                'deskripsi' => 'Pembahasan program kerja bulanan dan evaluasi.',
                'tanggal_mulai' => now()->addDays(rand(1, 30)),
                'tanggal_selesai' => now()->addDays(rand(1, 30))->addHours(3),
                'lokasi' => 'Kantor Sekretariat ' . $unit->nama,
                'status' => 'diterima',
                'catatan_ditolak' => null, // Karena diterima
            ]);

            Agenda::create([
                'organisasi_unit_id' => $unit->id,
                'nama' => 'Kaderisasi Angkatan I ' . $unit->nama,
                'deskripsi' => 'Pelatihan kepemimpinan tingkat dasar untuk anggota baru.',
                'tanggal_mulai' => now()->addDays(rand(31, 60)),
                'tanggal_selesai' => now()->addDays(rand(31, 60))->addDays(3), // 3 hari
                'lokasi' => 'Aula Serbaguna Kecamatan',
                'status' => 'permintaan',
                'catatan_ditolak' => null,
            ]);

            // --- SEED SURAT ---
            if ($unit->level !== 'pc') {
                $pembuat = User::where('organisasi_unit_id', $unit->id)->first()->id ?? $adminPc->id;

                // 1. Surat Keluar PENDING (LENGKAP)
                Surat::create([
                    'organisasi_unit_id' => $unit->id,
                    'index_surat_id' => $indexSk->id,
                    'nomor_surat' => '001/OUT/' . $unit->id . '/2026',
                    'perihal' => 'Permohonan Pengesahan SK ' . $unit->nama,
                    'jenis_surat' => 'keluar',
                    'pengirim' => $unit->nama,
                    'penerima' => 'PC GP Ansor Tulungagung',
                    'kategori_surat' => 'Administrasi',
                    'tanggal_surat' => now(),
                    'url_dokumen' => 'surat_dummy.pdf',
                    'status' => 'pending',
                    'catatan_ditolak' => null,
                    'diterima_oleh' => null,
                    'dibuat_oleh' => $pembuat,
                ]);

                // 2. Surat Keluar DITERIMA (LENGKAP)
                Surat::create([
                    'organisasi_unit_id' => $unit->id,
                    'index_surat_id' => $indexUndangan->id,
                    'nomor_surat' => '002/OUT/' . $unit->id . '/2026',
                    'perihal' => 'Undangan Silaturahmi ' . $unit->nama,
                    'jenis_surat' => 'keluar',
                    'pengirim' => $unit->nama,
                    'penerima' => 'Tokoh Masyarakat',
                    'kategori_surat' => 'Undangan',
                    'tanggal_surat' => now()->subDays(5),
                    'url_dokumen' => 'undangan_dummy.pdf',
                    'status' => 'diterima',
                    'catatan_ditolak' => null,
                    'diterima_oleh' => $adminPc->id,
                    'dibuat_oleh' => $pembuat,
                ]);
            }
        }

        // --- KHUSUS PC: Surat Masuk (LENGKAP) ---
        for ($i = 1; $i <= 3; $i++) {
            Surat::create([
                'organisasi_unit_id' => $pcUnit->id,
                'index_surat_id' => $indexSk->id,
                'nomor_surat' => "00$i/IN/PW/2026",
                'perihal' => "Instruksi PW Jawa Timur Ke-$i",
                'jenis_surat' => 'masuk',
                'pengirim' => 'PW GP Ansor Jawa Timur',
                'penerima' => 'PC GP Ansor Tulungagung',
                'kategori_surat' => 'Instruksi',
                'tanggal_surat' => now()->subDays($i),
                'url_dokumen' => 'instruksi_pw.pdf',
                'status' => 'diterima',
                'catatan_ditolak' => null,
                'diterima_oleh' => $adminPc->id,
                'dibuat_oleh' => null, // Surat masuk dari luar
            ]);
        }
    }
}