<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-2 h-6 bg-emerald-600 rounded-full"></div>
            <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">
                {{ __('Edit Profil Admin') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                <p class="text-emerald-600 text-sm font-medium">{{ session('success') }}</p>
            </div>
            @endif

            {{-- ERROR MESSAGES --}}
            @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li class="text-rose-600 text-sm font-medium">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white shadow-2xl overflow-hidden rounded-[2.5rem] border border-gray-100">

                {{-- HEADER --}}
                <div class="pt-8 pb-6 px-8 text-center border-b border-gray-100 bg-white">
                    <div class="flex justify-center mb-4">
                        @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Profile" class="h-20 w-20 rounded-full border-4 border-emerald-500 shadow-lg object-cover">
                        @else
                        <div class="h-20 w-20 rounded-full bg-emerald-500 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                        </div>
                        @endif
                    </div>
                    <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">{{ $user->nama }}</h2>
                    <p class="text-xs text-emerald-600 mt-1">{{ $user->email }}</p>
                    @if($organisasiUnit)
                    <p class="text-xs text-slate-500 mt-2 font-bold">{{ $organisasiUnit->nama }}</p>
                    @endif
                </div>

                <form method="POST" action="{{ route('admin.profile.update') }}" class="p-8 md:p-10 bg-white space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                        {{-- KOLOM KIRI: DATA PRIBADI --}}
                        <div class="space-y-5">
                            <div class="flex items-center gap-2 border-b border-gray-100 pb-2 mb-4">
                                <div class="h-8 w-1 bg-emerald-500 rounded-full"></div>
                                <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest">1. Data Pribadi</h3>
                            </div>

                            {{-- NIK --}}
                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">NIK (16 Digit) <span class="text-rose-500">*</span></label>
                                <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('nik') border-rose-500 @enderror"
                                    type="text" name="nik" value="{{ old('nik', $anggota->nik) }}" required placeholder="Nomor Induk Kependudukan" maxlength="16">
                            </div>

                            {{-- NIA --}}
                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">NIA (Nomor Induk Anggota)</label>
                                <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                    type="text" name="nia_ansor" value="{{ old('nia_ansor', $anggota->nia_ansor) }}" placeholder="Contoh: 12.05.03.xxxx">
                                <p class="text-[10px] text-slate-400 ml-1 font-medium italic">*Kosongi bila belum punya NIA</p>
                            </div>

                            {{-- TTL --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Tempat Lahir <span class="text-rose-500">*</span></label>
                                    <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('tempat_lahir') border-rose-500 @enderror"
                                        type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}" required placeholder="Kota Lahir">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                                    <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('tanggal_lahir') border-rose-500 @enderror"
                                        type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir?->format('Y-m-d')) }}" required>
                                </div>
                            </div>

                            {{-- Kelamin & Status --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                    <select name="kelamin" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                        <option value="L" {{ old('kelamin', $anggota->kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('kelamin', $anggota->kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Status Kawin <span class="text-rose-500">*</span></label>
                                    <select name="status_kawin" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                        <option value="belum_kawin" {{ old('status_kawin', $anggota->status_kawin) == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                        <option value="kawin" {{ old('status_kawin', $anggota->status_kawin) == 'kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="cerai_hidup" {{ old('status_kawin', $anggota->status_kawin) == 'cerai_hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="cerai_mati" {{ old('status_kawin', $anggota->status_kawin) == 'cerai_mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            {{-- No. Telp --}}
                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                                <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('notelp') border-rose-500 @enderror"
                                    type="text" name="notelp" value="{{ old('notelp', $anggota->notelp) }}" required placeholder="08xxxxxxxxxx">
                            </div>

                            {{-- ALAMAT DOMISILI --}}
                            <div class="space-y-5 pt-4">
                                <div class="flex items-center gap-2 border-b border-gray-100 pb-2 mb-4">
                                    <div class="h-8 w-1 bg-emerald-500 rounded-full"></div>
                                    <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest">2. Alamat Domisili</h3>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Alamat Lengkap <span class="text-rose-500">*</span></label>
                                    <textarea name="alamat" rows="2" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('alamat') border-rose-500 @enderror" placeholder="Jalan / Dusun / RT / RW">{{ old('alamat', $anggota->alamat) }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label class="block font-bold text-xs text-slate-700 ml-1">Kecamatan <span class="text-rose-500">*</span></label>
                                        <select id="domisili_kecamatan" name="kecamatan_id" onchange="fetchDesa('domisili_desa', this.value)" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                            <option value="" disabled>Pilih...</option>
                                            @foreach($kecamatans as $kec)
                                            <option value="{{ $kec->id }}" {{ old('kecamatan_id', $anggota->kecamatan_id) == $kec->id ? 'selected' : '' }}>{{ Str::title($kec->nama) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="block font-bold text-xs text-slate-700 ml-1">Desa <span class="text-rose-500">*</span></label>
                                        <select id="domisili_desa" name="desa_id" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                            @foreach($desasDomisili as $desa)
                                            <option value="{{ $desa->id }}" {{ old('desa_id', $anggota->desa_id) == $desa->id ? 'selected' : '' }}>{{ Str::title($desa->nama) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: PEKERJAAN & DATA ORGANISASI --}}
                        <div class="space-y-8">

                            {{-- PENDIDIKAN & PEKERJAAN --}}
                            <div class="space-y-5">
                                <div class="flex items-center gap-2 border-b border-gray-100 pb-2 mb-4">
                                    <div class="h-8 w-1 bg-emerald-500 rounded-full"></div>
                                    <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest">3. Pendidikan & Pekerjaan</h3>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label class="block font-bold text-xs text-slate-700 ml-1">Pendidikan Terakhir</label>
                                        <select name="last_education" class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                            <option value="SMA" {{ old('last_education', $anggota->last_education) == 'SMA' ? 'selected' : '' }}>SMA/Sederajat</option>
                                            <option value="D3" {{ old('last_education', $anggota->last_education) == 'D3' ? 'selected' : '' }}>Diploma (D3)</option>
                                            <option value="S1" {{ old('last_education', $anggota->last_education) == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                                            <option value="S2" {{ old('last_education', $anggota->last_education) == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                                            <option value="Pesantren" {{ old('last_education', $anggota->last_education) == 'Pesantren' ? 'selected' : '' }}>Pesantren</option>
                                            <option value="Lainnya" {{ old('last_education', $anggota->last_education) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="block font-bold text-xs text-slate-700 ml-1">Pekerjaan Utama</label>
                                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                            type="text" name="job_title" value="{{ old('job_title', $anggota->job_title) }}" placeholder="Guru, Petani, dll">
                                    </div>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Alamat Kantor/Usaha (Opsional)</label>
                                    <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                        type="text" name="job_address" value="{{ old('job_address', $anggota->job_address) }}" placeholder="Kota atau Alamat Tempat Bekerja">
                                </div>
                            </div>

                            {{-- DATA ORGANISASI UNIT --}}
                            @if($organisasiUnit)
                            <div class="space-y-5">
                                <div class="flex items-center gap-2 border-b border-gray-100 pb-2 mb-4">
                                    <div class="h-8 w-1 bg-indigo-500 rounded-full"></div>
                                    <h3 class="text-sm font-black text-indigo-600 uppercase tracking-widest">4. Data Organisasi Unit</h3>
                                </div>

                                <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-xl">
                                    <p class="text-xs font-bold text-indigo-700 mb-1">{{ $organisasiUnit->nama }}</p>
                                    <p class="text-[10px] text-indigo-500 uppercase tracking-wider">{{ $organisasiUnit->level }}</p>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Alamat Sekretariat</label>
                                    <textarea name="unit_alamat_sekretariat" rows="2" class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all" placeholder="Alamat lengkap sekretariat">{{ old('unit_alamat_sekretariat', $organisasiUnit->alamat_sekretariat) }}</textarea>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Email Organisasi</label>
                                    <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                        type="email" name="unit_email" value="{{ old('unit_email', $organisasiUnit->email) }}" placeholder="email@organisasi.com">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">No. Telp Sekretariat</label>
                                    <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                        type="text" name="unit_notelp" value="{{ old('unit_notelp', $organisasiUnit->notelp) }}" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                    {{-- FOOTER BUTTONS --}}
                    <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-center gap-4 mt-4">
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-3 border-2 border-slate-200 text-slate-500 rounded-2xl text-sm font-bold uppercase tracking-widest text-center hover:bg-slate-50 transition-all">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-12 py-3 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-2xl text-sm font-black uppercase tracking-widest shadow-lg shadow-emerald-100 hover:shadow-xl hover:shadow-emerald-200 transform hover:-translate-y-1 active:scale-95 transition-all duration-300">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- SCRIPT LOGIC --}}
    <script>
        async function fetchDesa(targetId, kecamatanId) {
            const selectTarget = document.getElementById(targetId);
            selectTarget.innerHTML = '<option>Loading...</option>';

            try {
                const res = await fetch(`/desa/${kecamatanId}`);
                const data = await res.json();

                selectTarget.innerHTML = '<option value="" selected disabled>Pilih Desa...</option>';

                data.forEach(d => {
                    let opt = document.createElement('option');
                    opt.value = d.id;
                    opt.text = toTitleCase(d.nama);
                    selectTarget.add(opt);
                });
            } catch (err) {
                console.error(err);
                selectTarget.innerHTML = '<option>Gagal memuat data</option>';
            }
        }

        function toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }
    </script>
</x-app-layout>