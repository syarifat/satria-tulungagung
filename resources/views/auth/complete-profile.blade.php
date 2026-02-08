<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lengkapi Profil - {{ config('app.name', 'Satria Tulungagung') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/logo-tab.png?v=1') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo-tab.png?v=1') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/logo-tab.png?v=1') }}">
    <link rel="shortcut icon" href="{{ asset('img/logo-tab.png?v=1') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        textarea::-webkit-scrollbar {
            width: 8px;
        }

        textarea::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased bg-slate-50 selection:bg-emerald-500 selection:text-white">

    <div class="min-h-screen flex flex-col justify-center items-center py-10 px-4">

        {{-- CARD COMPLETE PROFILE --}}
        <div class="w-full sm:max-w-5xl bg-white shadow-2xl overflow-hidden rounded-[2.5rem] border border-gray-100 relative">

            {{-- HEADER --}}
            <div class="pt-10 pb-6 px-8 text-center border-b border-gray-100 bg-white">
                <div class="flex justify-center mb-4">
                    @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="Profile" class="h-20 w-20 rounded-full border-4 border-emerald-500 shadow-lg object-cover">
                    @else
                    <div class="h-20 w-20 rounded-full bg-emerald-500 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                    @endif
                </div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Halo, {{ $user->nama }}!</h2>
                <p class="text-sm text-slate-500 mt-2 font-medium">Lengkapi data profil Anda untuk melanjutkan</p>
                <p class="text-xs text-emerald-600 mt-1">{{ $user->email }}</p>
            </div>

            {{-- REGISTRATION INFO --}}
            <div class="mx-8 mt-6 p-4 bg-emerald-50 border border-emerald-100 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-emerald-700">Pendaftaran Anggota Baru</p>
                        <p class="text-[10px] text-emerald-600">Lengkapi data diri dan organisasi untuk mendapatkan KTA Digital.</p>
                    </div>
                </div>
            </div>
            @if ($errors->any())
            <div class="mx-8 mt-6 p-4 bg-rose-50 border border-rose-200 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li class="text-rose-600 text-sm font-medium">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('complete-profile.store') }}" enctype="multipart/form-data" class="p-8 md:p-10 bg-white space-y-8">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                    {{-- KOLOM KIRI: DATA PRIBADI --}}
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 border-b border-gray-100 pb-2 mb-4">
                            <div class="h-8 w-1 bg-emerald-500 rounded-full"></div>
                            <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest">1. Data Pribadi</h3>
                        </div>

                        {{-- NAMA & FOTO --}}
                        <div class="space-y-5">
                            <div class="flex flex-col items-center gap-4 mb-6">
                                <div class="relative group">
                                    @if($user->avatar)
                                    <img id="avatar-preview" src="{{ $user->avatar }}" alt="Profile" class="h-24 w-24 rounded-full border-4 border-emerald-500 shadow-lg object-cover">
                                    @else
                                    <div id="avatar-placeholder" class="h-24 w-24 rounded-full bg-emerald-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                                    </div>
                                    <img id="avatar-preview" class="h-24 w-24 rounded-full border-4 border-emerald-500 shadow-lg object-cover hidden">
                                    @endif

                                    <label for="foto_profil" class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md border border-gray-200 cursor-pointer hover:bg-emerald-50 transition-colors">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </label>
                                    <input type="file" id="foto_profil" name="foto_profil" class="hidden" accept="image/*" onchange="previewImage(this)">
                                </div>
                                <p class="text-[10px] text-slate-400 font-medium">Klik kamera untuk ubah foto</p>
                            </div>

                            {{-- NAMA LENGKAP --}}
                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input class="block w-full {{ $errors->has('nama') ? 'border-rose-500' : 'border-gray-200' }} bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                    type="text" name="nama" value="{{ old('nama', $user->nama) }}" required placeholder="Nama Lengkap Sesuai KTP">
                            </div>
                        </div>

                        {{-- NIK --}}
                        <div class="space-y-1.5">
                            <label class="block font-bold text-xs text-slate-700 ml-1">NIK (16 Digit) <span class="text-rose-500">*</span></label>
                            <input class="block w-full {{ $errors->has('nik') ? 'border-rose-500' : 'border-gray-200' }} bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                type="text" name="nik" value="{{ old('nik') }}" required placeholder="Nomor Induk Kependudukan" maxlength="16">
                        </div>

                        {{-- NIA --}}
                        <div class="space-y-1.5">
                            <label class="block font-bold text-xs text-slate-700 ml-1">NIA (Nomor Induk Anggota)</label>
                            <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                type="text" name="nia_ansor" value="{{ old('nia_ansor') }}" placeholder="Contoh: 12.05.03.xxxx">
                            <p class="text-[10px] text-slate-400 ml-1 font-medium italic">*Kosongi bila belum punya NIA</p>
                        </div>

                        {{-- TTL --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">Tempat Lahir <span class="text-rose-500">*</span></label>
                                <input class="block w-full {{ $errors->has('tempat_lahir') ? 'border-rose-500' : 'border-gray-200' }} bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                    type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Kota Lahir">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                                <input class="block w-full {{ $errors->has('tanggal_lahir') ? 'border-rose-500' : 'border-gray-200' }} bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                    type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            </div>
                        </div>

                        {{-- Kelamin & Status --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                <select name="kelamin" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                    <option value="L" {{ old('kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">Status Kawin <span class="text-rose-500">*</span></label>
                                <select name="status_kawin" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                    <option value="belum_kawin" {{ old('status_kawin') == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="kawin" {{ old('status_kawin') == 'kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="cerai_hidup" {{ old('status_kawin') == 'cerai_hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="cerai_mati" {{ old('status_kawin') == 'cerai_mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                            </div>
                        </div>

                        {{-- No. Telp --}}
                        <div class="space-y-1.5">
                            <label class="block font-bold text-xs text-slate-700 ml-1">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                            <input class="block w-full {{ $errors->has('notelp') ? 'border-rose-500' : 'border-gray-200' }} bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                type="text" name="notelp" value="{{ old('notelp') }}" required placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    {{-- KOLOM KANAN: ALAMAT, ORGANISASI, PEKERJAAN --}}
                    <div class="space-y-8">

                        {{-- ALAMAT DOMISILI --}}
                        <div class="space-y-5">
                            <div class="flex items-center gap-2 border-b border-gray-100 pb-2 mb-4">
                                <div class="h-8 w-1 bg-emerald-500 rounded-full"></div>
                                <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest">2. Alamat Domisili</h3>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">Alamat Lengkap <span class="text-rose-500">*</span></label>
                                <textarea name="alamat" rows="2" required class="block w-full {{ $errors->has('alamat') ? 'border-rose-500' : 'border-gray-200' }} bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all" placeholder="Jalan / Dusun / RT / RW">{{ old('alamat') }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Kecamatan <span class="text-rose-500">*</span></label>
                                    <select id="domisili_kecamatan" name="kecamatan_id" onchange="fetchDesa('domisili_desa', this.value)" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                        <option value="" selected disabled>Pilih...</option>
                                        @foreach($kecamatans as $kec)
                                        <option value="{{ $kec->id }}" {{ old('kecamatan_id') == $kec->id ? 'selected' : '' }}>{{ Str::title($kec->nama) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Desa <span class="text-rose-500">*</span></label>
                                    <select id="domisili_desa" name="desa_id" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                        <option value="" selected disabled>Pilih Kecamatan dulu</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- SATUAN ORGANISASI --}}
                        <div class="space-y-5">
                            <div class="flex items-center gap-2 border-b border-gray-100 pb-2 mb-4">
                                <div class="h-8 w-1 bg-emerald-500 rounded-full"></div>
                                <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest">3. Satuan Organisasi</h3>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">Tingkatan Organisasi <span class="text-rose-500">*</span></label>
                                <select id="tingkatan_organisasi" name="tingkatan_organisasi" onchange="toggleSatuan()" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                    <option value="" selected disabled>Pilih Tingkatan...</option>
                                    <option value="pac" {{ old('tingkatan_organisasi') == 'pac' ? 'selected' : '' }}>Pimpinan Anak Cabang (Kecamatan)</option>
                                    <option value="pr" {{ old('tingkatan_organisasi') == 'pr' ? 'selected' : '' }}>Pimpinan Ranting (Desa)</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                {{-- Pilih PAC --}}
                                <div id="wrapper_pac" class="hidden space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Pilih PAC (Kecamatan) <span class="text-rose-500">*</span></label>
                                    <select id="unit_kecamatan" name="unit_kecamatan_id" onchange="fetchDesa('unit_desa', this.value, true)" class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                        <option value="" selected disabled>Pilih PAC...</option>
                                        @foreach($kecamatans as $kec)
                                        <option value="{{ $kec->id }}" {{ old('unit_kecamatan_id') == $kec->id ? 'selected' : '' }}>PAC GP Ansor {{ Str::title($kec->nama) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Pilih PR --}}
                                <div id="wrapper_pr" class="hidden space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Pilih PR (Desa) <span class="text-rose-500">*</span></label>
                                    <select id="unit_desa" name="unit_desa_id" class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                        <option value="" selected disabled>Pilih PAC Dulu...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- JABATAN --}}
                        <div class="space-y-1.5">
                            <label class="block font-bold text-xs text-slate-700 ml-1">Jabatan dalam Organisasi <span class="text-rose-500">*</span></label>
                            <select name="jabatan_id" required class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                <option value="" selected disabled>Pilih Jabatan...</option>
                                @foreach($jabatans as $jab)
                                <option value="{{ $jab->id }}" {{ old('jabatan_id') == $jab->id ? 'selected' : '' }}>{{ $jab->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- PENDIDIKAN & PEKERJAAN --}}
                        <div class="space-y-5">
                            <div class="flex items-center gap-2 border-b border-gray-100 pb-2 mb-4">
                                <div class="h-8 w-1 bg-emerald-500 rounded-full"></div>
                                <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest">4. Pendidikan & Pekerjaan</h3>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Pendidikan Terakhir</label>
                                    <select name="last_education" class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all cursor-pointer">
                                        <option value="SMA" {{ old('last_education') == 'SMA' ? 'selected' : '' }}>SMA/Sederajat</option>
                                        <option value="D3" {{ old('last_education') == 'D3' ? 'selected' : '' }}>Diploma (D3)</option>
                                        <option value="S1" {{ old('last_education') == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                                        <option value="S2" {{ old('last_education') == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                                        <option value="Pesantren" {{ old('last_education') == 'Pesantren' ? 'selected' : '' }}>Pesantren</option>
                                        <option value="Lainnya" {{ old('last_education') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block font-bold text-xs text-slate-700 ml-1">Pekerjaan Utama</label>
                                    <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                        type="text" name="job_title" value="{{ old('job_title') }}" placeholder="Guru, Petani, dll">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block font-bold text-xs text-slate-700 ml-1">Alamat Kantor/Usaha (Opsional)</label>
                                <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all"
                                    type="text" name="job_address" value="{{ old('job_address') }}" placeholder="Kota atau Alamat Tempat Bekerja">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- FOOTER BUTTONS --}}
                <div class="pt-8 border-t border-gray-100 flex flex-col items-center gap-4 mt-4">
                    <button type="submit" class="w-full sm:w-1/2 justify-center py-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-2xl text-sm font-black uppercase tracking-widest shadow-lg shadow-emerald-100 hover:shadow-xl hover:shadow-emerald-200 transform hover:-translate-y-1 active:scale-95 transition-all duration-300">
                        Simpan & Lanjutkan
                    </button>

                    <div class="text-center">
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm text-slate-500 hover:text-rose-600 font-bold transition-colors rounded-lg hover:bg-rose-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar / Ganti Akun
                            </button>
                        </form>
                    </div>
                </div>

                {{-- COPYRIGHT --}}
                <div class="text-center pt-6">
                    <p class="text-[9px] text-slate-300 font-bold uppercase tracking-[0.2em]">
                        {{ config('app.name') }} © {{ date('Y') }}
                    </p>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT LOGIC --}}
    <script>
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleSatuan();
        });

        function toggleSatuan() {
            const tingkatan = document.getElementById('tingkatan_organisasi').value;
            const wrapperPac = document.getElementById('wrapper_pac');
            const wrapperPr = document.getElementById('wrapper_pr');
            const selectPac = document.getElementById('unit_kecamatan');
            const selectPr = document.getElementById('unit_desa');

            // Reset tampilan & required
            wrapperPac.classList.add('hidden');
            wrapperPr.classList.add('hidden');
            selectPac.removeAttribute('required');
            selectPr.removeAttribute('required');

            if (tingkatan === 'pac') {
                wrapperPac.classList.remove('hidden');
                selectPac.setAttribute('required', 'required');
            } else if (tingkatan === 'pr') {
                wrapperPac.classList.remove('hidden');
                wrapperPr.classList.remove('hidden');
                selectPac.setAttribute('required', 'required');
                selectPr.setAttribute('required', 'required');
            }
        }

        async function fetchDesa(targetId, kecamatanId, isUnit = false) {
            const selectTarget = document.getElementById(targetId);
            selectTarget.innerHTML = '<option>Loading...</option>';

            try {
                const res = await fetch(`/desa/${kecamatanId}`);
                const data = await res.json();

                selectTarget.innerHTML = isUnit ?
                    '<option value="" selected disabled>Pilih Ranting (PR)...</option>' :
                    '<option value="" selected disabled>Pilih Desa...</option>';

                data.forEach(d => {
                    let opt = document.createElement('option');
                    opt.value = d.id;
                    let namaWilayah = toTitleCase(d.nama);
                    opt.text = isUnit ? `PR GP Ansor ${namaWilayah}` : namaWilayah;
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

        function previewImage(input) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>