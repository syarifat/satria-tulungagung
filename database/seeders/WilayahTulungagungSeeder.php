<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahTulungagungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Matikan Foreign Key Check biar aman saat truncate/insert ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('desas')->truncate();
        DB::table('kecamatans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ==========================================
        // DATA KECAMATAN & DESA SE-TULUNGAGUNG (35.04)
        // ==========================================
        
        $data = [
            '350401' => [
                'nama' => 'Tulungagung',
                'desas' => ['Kampungdalem', 'Kauman', 'Kedungsoko', 'Kenayan', 'Kepatihan', 'Kutoanyar', 'Panggungrejo', 'Sembung', 'Tamanan', 'Tertek', 'Bago', 'Botoran', 'Jepun', 'Karangwaru']
            ],
            '350402' => [
                'nama' => 'Boyolangu',
                'desas' => ['Beji', 'Bono', 'Boyolangu', 'Gedangsewu', 'Karangrejo', 'Kendalbulur', 'Moyoketen', 'Ngranti', 'Pucungkidul', 'Sanggrahan', 'Serut', 'Sobontoro', 'Tanjungsari', 'Wajakkidul', 'Wajaklor', 'Waung', 'Wates']
            ],
            '350403' => [
                'nama' => 'Kedungwaru',
                'desas' => ['Bangoan', 'Boro', 'Bulumatsan', 'Gendingan', 'Kedungwaru', 'Ketanon', 'Lodan Wetan', 'Mangunsari', 'Ngujang', 'Plandaan', 'Plosokandang', 'Rejoagung', 'Ringinpitu', 'Simpyang', 'Tapan', 'Tawangsari', 'Tungbale', 'Winong', 'Gecig']
            ],
            '350404' => [
                'nama' => 'Ngantru',
                'desas' => ['Banjarsari', 'Batokan', 'Bendosari', 'Kepuhrejo', 'Mojoagung', 'Ngantru', 'Padangan', 'Pakel', 'Pinggirsari', 'Pojok', 'Pucunglor', 'Pulerejo', 'Srikaton']
            ],
            '350405' => [
                'nama' => 'Kauman',
                'desas' => ['Balerejo', 'Banaran', 'Batangsaren', 'Bolorejo', 'Jatimulyo', 'Kalangbret', 'Karanganom', 'Kates', 'Kauman', 'Mojosari', 'Panggungrejo', 'Pucangan', 'Sidorejo']
            ],
            '350406' => [
                'nama' => 'Pagerwojo',
                'desas' => ['Gambiran', 'Gondanggunung', 'Kedungcangkring', 'Keling', 'Mulyosari', 'Pagerwojo', 'Penjor', 'Samar', 'Segoto', 'Sidomulyo', 'Wonorejo']
            ],
            '350407' => [
                'nama' => 'Sendang',
                'desas' => ['Donorejo', 'Geger', 'Kedoyo', 'Krosok', 'Nglurup', 'Nunggup', 'Nyawangan', 'Picisan', 'Sendang', 'Talang', 'Tugu']
            ],
            '350408' => [
                'nama' => 'Karangrejo',
                'desas' => ['Babadan', 'Bungur', 'Gedangan', 'Jeli', 'Karangrejo', 'Kunyit', 'Sembon', 'Sukodono', 'Sukorejo', 'Sukowidodo', 'Sukowiyono', 'Tanjungsari', 'Tulungrejo']
            ],
            '350409' => [
                'nama' => 'Gondang',
                'desas' => ['Bendasari', 'Bendungan', 'Blendis', 'Dukuh', 'Gondang', 'Gondosuli', 'Jarakan', 'Kendal', 'Kiping', 'Macanbang', 'Mojoayu', 'Ngrendeng', 'Notorejo', 'Rejosari', 'Sepatan', 'Sidem', 'Sidomulyo', 'Tiudan', 'Wonokromo', 'Boro']
            ],
            '350410' => [
                'nama' => 'Sumbergempol',
                'desas' => ['Bendiljati Kulon', 'Bendiljati Wetan', 'Bukur', 'Doroampel', 'Jabalsari', 'Jungkruk', 'Mirigambar', 'Podorejo', 'Sambidoplang', 'Sambijajar', 'Sambirobyong', 'Sumberdadi', 'Tambakrejo', 'Trenceng', 'Wates', 'Wonorejo', 'Gamping']
            ],
            '350411' => [
                'nama' => 'Ngunut',
                'desas' => ['Balesono', 'Gilang', 'Kacangan', 'Kalangan', 'Kaliwungu', 'Karangsono', 'Kromasan', 'Ngunut', 'Pandanarum', 'Pulosari', 'Purworejo', 'Samir', 'Selorejo', 'Sumberejo Kulon', 'Sumberejo Wetan', 'Sumberingin Kulon', 'Sumberingin Kidul', 'Tanen']
            ],
            '350412' => [
                'nama' => 'Pucanglaban',
                'desas' => ['Demuk', 'Kaligentong', 'Mandalawangi', 'Panggungkalak', 'Panggunguni', 'Pucanglaban', 'Sumberbendo', 'Sumberdadap', 'Tanjung']
            ],
            '350413' => [
                'nama' => 'Rejotangan',
                'desas' => ['Ariyojeding', 'Banjarejo', 'Blimbing', 'Buntaran', 'Jatidowo', 'Karangsari', 'Pakisrejo', 'Panjerejo', 'Rejotangan', 'Sukorejo Wetan', 'Sumberagung', 'Tanungsari', 'Tegalrejo', 'Tenggong', 'Tugu', 'Tulungrejo']
            ],
            '350414' => [
                'nama' => 'Kalidawir',
                'desas' => ['Banyuurip', 'Betak', 'Domasan', 'Jabon', 'Joho', 'Kalibatur', 'Kalidawir', 'Karangtalun', 'Ngubalan', 'Pagersari', 'Pakisaji', 'Rejosari', 'Salakkembang', 'Sukorejo', 'Tanjung', 'Tunggangri', 'Winong']
            ],
            '350415' => [
                'nama' => 'Besuki',
                'desas' => ['Besole', 'Besuki', 'Keboireng', 'Ngentrong', 'Sawah', 'Sedayu Gunung', 'Siyotobagus', 'Tanggulkundung', 'Tulungrejo', 'Wates Kroyo']
            ],
            '350416' => [
                'nama' => 'Campurdarat',
                'desas' => ['Campurdarat', 'Gamping', 'Gedangan', 'Ngentrong', 'Pelem', 'Pojok', 'Sawo', 'Tanggung', 'Wates']
            ],
            '350417' => [
                'nama' => 'Pakel',
                'desas' => ['Bangkalsari', 'Bangunjaya', 'Bondo', 'Duwet', 'Gebang', 'Gempolan', 'Gesikan', 'Gombang', 'Kesreman', 'Ngebong', 'Ngrance', 'Pakel', 'Pecuk', 'Sambitan', 'Sanana', 'Sodo', 'Sukoanyar', 'Suwaluh', 'Tamban']
            ],
            '350418' => [
                'nama' => 'Bandung',
                'desas' => ['Bandung', 'Bantengan', 'Bulus', 'Gandong', 'Kedungwilut', 'Kesambi', 'Mergayu', 'Nglampir', 'Ngunggahan', 'Sebalor', 'Singgit', 'Soko', 'Sukoharjo', 'Suruhan Kidul', 'Suruhan Lor', 'Suwaru', 'Talun Kulon', 'Tulungrejo']
            ],
            '350419' => [
                'nama' => 'Tanggunggunung',
                'desas' => ['Jengglungharjo', 'Kresikan', 'Ngepoh', 'Ngrejo', 'Pakisrejo', 'Tanggunggunung', 'Tenggarejo']
            ]
        ];

        // LOGIKA INSERT
        $kecamatans = [];
        $desas = [];
        $now = now();

        foreach ($data as $kecId => $value) {
            // Masukkan Kecamatan
            $kecamatans[] = [
                'id' => $kecId,
                'nama' => $value['nama'],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Masukkan Desa
            // Logic ID Desa: Kode Kecamatan + Urutan (Mulai 2001)
            // Contoh: Boyolangu (350402) -> Beji (3504022001)
            $counter = 2001; 
            foreach ($value['desas'] as $namaDesa) {
                $desas[] = [
                    'id' => $kecId . $counter,
                    'kecamatan_id' => $kecId,
                    'nama' => $namaDesa,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                $counter++;
            }
        }

        // Eksekusi Insert
        DB::table('kecamatans')->insert($kecamatans);
        
        // Chunk insert desa agar tidak overload query jika data banyak
        foreach (array_chunk($desas, 100) as $chunk) {
            DB::table('desas')->insert($chunk);
        }
    }
}