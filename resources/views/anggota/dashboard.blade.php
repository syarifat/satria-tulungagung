<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Profil Saya') }}
            </h2>
            <a href="{{ route('anggota.profile.edit') }}" class="flex items-center gap-2 px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit Profil
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- PROFILE HEADER CARD --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
                <div class="relative bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-900 p-8 md:p-12">
                    <div class="absolute right-[-40px] bottom-[-60px] opacity-10 text-[12rem] font-black rotate-12 select-none pointer-events-none tracking-tighter text-white">
                        ANSOR
                    </div>
                    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center gap-6">
                        {{-- Avatar --}}
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl bg-white shadow-xl flex items-center justify-center text-slate-300 shrink-0 border-4 border-white/20">
                            @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="{{ $anggota->nama }}" class="w-full h-full object-cover rounded-2xl">
                            @else
                            <svg class="w-16 h-16 md:w-20 md:h-20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="text-white flex-1">
                            <h3 class="text-3xl md:text-4xl font-black mb-2 tracking-tight">{{ $anggota->nama }}</h3>
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-xs font-bold uppercase tracking-wider border border-white/30">
                                    {{ optional($anggota->jabatan)->nama ?? 'Anggota' }}
                                </span>
                                <span class="px-3 py-1 bg-yellow-400/20 backdrop-blur-md rounded-lg text-xs font-bold uppercase tracking-wider border border-yellow-400/30 text-yellow-200">
                                    {{ optional($anggota->organisasiUnit)->nama ?? '-' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ Auth::user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DATA GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- DATA PRIBADI --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 p-8">
                    <div class="flex items-center gap-2 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-2 h-6 bg-emerald-600 rounded-full"></div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Data Pribadi</h4>
                    </div>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">NIK</p>
                                <p class="font-mono font-bold text-slate-800">{{ $anggota->nik ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">NIA Ansor</p>
                                <p class="font-mono font-bold text-slate-800">{{ $anggota->nia_ansor ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Tempat, Tanggal Lahir</p>
                                <p class="font-bold text-slate-800">{{ $anggota->tempat_lahir ?? '-' }}, {{ $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('d F Y') : '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Jenis Kelamin</p>
                                <p class="font-bold text-slate-800">{{ $anggota->kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">No. Telepon</p>
                                <p class="font-bold text-slate-800">{{ $anggota->notelp ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ALAMAT & DOMISILI --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 p-8">
                    <div class="flex items-center gap-2 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Alamat & Domisili</h4>
                    </div>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Alamat Lengkap</p>
                                <p class="font-medium text-slate-800 leading-relaxed">{{ $anggota->alamat ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Desa / Kelurahan</p>
                                <p class="font-bold text-slate-800">{{ optional($anggota->desa)->nama ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Kecamatan</p>
                                <p class="font-bold text-slate-800">{{ optional($anggota->kecamatan)->nama ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ORGANISASI --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 p-8">
                    <div class="flex items-center gap-2 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-2 h-6 bg-orange-600 rounded-full"></div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Organisasi</h4>
                    </div>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Unit Organisasi</p>
                                <p class="font-bold text-slate-800 uppercase">{{ optional($anggota->organisasiUnit)->nama ?? '-' }}</p>
                                <span class="inline-block mt-1 text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded uppercase">{{ optional($anggota->organisasiUnit)->level ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Jabatan</p>
                                <p class="font-bold text-slate-800 uppercase">{{ optional($anggota->jabatan)->nama ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PENDIDIKAN & PEKERJAAN --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 p-8">
                    <div class="flex items-center gap-2 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-2 h-6 bg-purple-600 rounded-full"></div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Pendidikan & Pekerjaan</h4>
                    </div>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Pendidikan Terakhir</p>
                                <p class="font-bold text-slate-800">{{ $anggota->last_education ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Bidang & Jenis Usaha</p>
                                <p class="font-bold text-slate-800">{{ $anggota->business_sector ?? '-' }}</p>
                                @if($anggota->business_type)
                                <p class="text-sm text-slate-600 mt-1 italic">"{{ $anggota->business_type }}"</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Minat Usaha</p>
                                <p class="font-bold text-slate-800">{{ $anggota->business_interest ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>