<?php

namespace Database\Seeders;

use App\Models\OrganisasiUnit;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\RiwayatPengkaderan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrganisasiDanAnggotaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Anggota::truncate();
        RiwayatPengkaderan::truncate(); // Reset riwayat juga
        OrganisasiUnit::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $password = Hash::make('password');
        $faker = Faker::create('id_ID'); // Pakai Faker Indonesia

        // 2. BUAT UNIT PC (Pusat Cabang) - ISI LENGKAP
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
        
        $this->createMembers($pc, 'pc_', 'admin_pc', $password, $faker);

        // 3. AMBIL SEMUA KECAMATAN UNTUK BUAT PAC
        $kecamatans = Kecamatan::all();

        foreach ($kecamatans as $kec) {
            $pac = OrganisasiUnit::create([
                'nama' => 'PAC GP Ansor ' . $kec->nama,
                'level' => 'pac',
                'parent_id' => $pc->id,
                'kecamatan_id' => $kec->id,
                'desa_id' => null,
                'alamat_sekretariat' => 'Jl. Raya Kecamatan ' . $kec->nama . ' No. ' . rand(1, 50),
                'email' => 'pac.' . strtolower(str_replace(' ', '', $kec->nama)) . '@ansor.or.id',
                'notelp' => '0812' . rand(10000000, 99999999),
            ]);

            $emailPrefixPac = 'pac_' . $kec->id . '_';
            $this->createMembers($pac, $emailPrefixPac, 'admin_pac', $password, $faker);

            // 4. BUAT PR (Pimpinan Ranting) DI SETIAP PAC
            $desas = Desa::where('kecamatan_id', $kec->id)->get();

            foreach ($desas as $desa) {
                $pr = OrganisasiUnit::create([
                    'nama' => 'PR GP Ansor ' . $desa->nama,
                    'level' => 'pr',
                    'parent_id' => $pac->id,
                    'kecamatan_id' => $kec->id,
                    'desa_id' => $desa->id,
                    'alamat_sekretariat' => 'Jl. Desa ' . $desa->nama . ' RT 01 RW 01',
                    'email' => 'pr.' . strtolower(str_replace(' ', '', $desa->nama)) . '@ansor.or.id',
                    'notelp' => '0857' . rand(10000000, 99999999),
                ]);

                $emailPrefixPr = 'pr_' . $desa->id . '_';
                $this->createMembers($pr, $emailPrefixPr, 'admin_pr', $password, $faker);
            }
        }
    }

    private function createMembers($unit, $emailPrefix, $adminRole, $password, $faker)
    {
        // Ambil random desa di Tulungagung untuk alamat domisili anggota (random sampling)
        $randomDesa = Desa::inRandomOrder()->first(); 

        for ($i = 1; $i <= 5; $i++) {
            $isLeader = ($i == 1);
            $currentRole = $isLeader ? $adminRole : 'anggota';
            $jabatanId = $isLeader ? 1 : 10; 

            // Buat Akun User
            $user = User::create([
                'nama' => ($isLeader ? "Ketua " : "Anggota $i ") . $unit->nama,
                'email' => $emailPrefix . $i . "@ansor.com",
                'password' => $password,
                'organisasi_unit_id' => $unit->id,
                'role' => $currentRole, 
                'is_active' => true,
            ]);

            $nikRandom = $this->generateUniqueNik();
            $niaRandom = '13.04.' . rand(10, 99) . '.' . rand(1000, 9999); // Contoh format NIA

            // Buat Profil Anggota (LENGKAP SEMUA FIELD)
            $anggota = Anggota::create([
                'user_id' => $user->id,
                'organisasi_unit_id' => $unit->id,
                'jabatan_id' => $jabatanId,
                'nik' => $nikRandom,
                'nia_ansor' => $niaRandom,
                'nama' => $user->nama,
                'tempat_lahir' => 'Tulungagung',
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'kelamin' => 'L',
                'status_kawin' => $faker->randomElement(['belum_kawin', 'kawin']),
                'notelp' => $faker->phoneNumber,
                'url_foto' => null, // Bisa diisi path dummy image jika ada
                'alamat' => $faker->address,
                'kecamatan_id' => $randomDesa->kecamatan_id, // Asumsi domisili random
                'desa_id' => $randomDesa->id,                // Asumsi domisili random
                'last_education' => $faker->randomElement(['SMA', 'S1', 'S2', 'Pesantren']),
                'job_title' => $faker->jobTitle,
                'job_address' => $faker->city,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Tambahkan Riwayat Pengkaderan (Agar tabel riwayat_pengkaderans terisi)
            RiwayatPengkaderan::create([
                'anggota_id' => $anggota->id,
                'jenis_pengkaderan' => 'PKD', // Pelatihan Kepemimpinan Dasar
                'tanggal_pelaksanaan' => now()->subYears(rand(1, 3)),
                'pelaksana' => 'PAC GP Ansor ' . ($unit->level == 'pac' ? 'Setempat' : 'Tetangga'),
                'nomor_sertifikat' => 'PKD/2023/' . rand(1000, 9999),
                'url_dokumen' => null,
            ]);

            // Jika Ketua, tambahkan riwayat lanjutan
            if ($isLeader) {
                RiwayatPengkaderan::create([
                    'anggota_id' => $anggota->id,
                    'jenis_pengkaderan' => 'PKL', // Pelatihan Kepemimpinan Lanjutan
                    'tanggal_pelaksanaan' => now()->subMonths(rand(1, 11)),
                    'pelaksana' => 'PC GP Ansor Tulungagung',
                    'nomor_sertifikat' => 'PKL/2024/' . rand(1000, 9999),
                    'url_dokumen' => null,
                ]);
            }
        }
    }

    private function generateUniqueNik()
    {
        return str_pad(mt_rand(1, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }
}