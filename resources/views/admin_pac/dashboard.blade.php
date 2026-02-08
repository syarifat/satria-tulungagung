<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            {{-- PILL HEADER (INDIGO) --}}
            <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
            <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">
                {{ __('Dashboard Pimpinan Anak Cabang') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            {{-- HERO BANNER (GRADIENT INDIGO - WAJIB GELAP AGAR TEKS KUNING TERBACA) --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-indigo-900 p-10 md:p-16 rounded-[3.5rem] shadow-2xl text-white border-b-8 border-indigo-800/50">
                <div class="relative z-10">
                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-4 inline-block border border-white/30">
                        PAC {{ Auth::user()->organisasiUnit->nama }}
                    </span>
                    <h3 class="text-3xl md:text-5xl font-black mb-3 tracking-tighter">
                        Selamat Datang, <br>Sahabat <span class="text-yellow-300">{{ Auth::user()->nama }}</span>!
                    </h3>
                    <div class="flex items-center gap-2 mt-6">
                        <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center animate-bounce shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-indigo-50 font-bold italic text-sm">
                            Ada <span class="underline decoration-yellow-400 decoration-2 underline-offset-4">{{ $stats['surat_pending'] }} surat</span> yang menunggu keputusan Anda hari ini.
                        </p>
                    </div>
                </div>
                
                {{-- WATERMARK BACKGROUND --}}
                <div class="absolute right-[-40px] bottom-[-60px] opacity-10 text-[18rem] font-black rotate-12 select-none pointer-events-none tracking-tighter uppercase">
                    ANSOR
                </div>
            </div>

            {{-- STATS GRID (STRUKTUR SAMA DENGAN PC) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Card 1 --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 hover:-translate-y-2 transition-transform duration-300 group">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 group-hover:text-indigo-500 transition-colors">Total Kader</p>
                    <p class="text-5xl font-black text-slate-800 tracking-tighter">{{ number_format($stats['total_anggota']) }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Wilayah Kecamatan</p>
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">&rarr;</div>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 hover:-translate-y-2 transition-transform duration-300 group">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 group-hover:text-indigo-500 transition-colors">Unit Ranting</p>
                    <p class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats['total_ranting'] }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Tingkat Desa</p>
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">&rarr;</div>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 hover:-translate-y-2 transition-transform duration-300 group">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 group-hover:text-indigo-500 transition-colors">Agenda Aktif</p>
                    <p class="text-5xl font-black text-slate-800 tracking-tighter">{{ $stats['agenda_aktif'] }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-emerald-500 uppercase">Disetujui</p>
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">&rarr;</div>
                    </div>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-indigo-100 bg-indigo-50/30 hover:-translate-y-2 transition-transform duration-300 group">
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] mb-4">Surat Pending</p>
                    <p class="text-5xl font-black text-indigo-800 tracking-tighter">{{ $stats['surat_pending'] }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-indigo-400 uppercase italic">Menunggu PC</p>
                        <div class="w-8 h-8 rounded-xl bg-white text-indigo-600 flex items-center justify-center font-bold text-xs shadow-sm">&rarr;</div>
                    </div>
                </div>
            </div>

            {{-- BOTTOM SECTION (GRID 1:2 SEPERTI PC) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI (Akses Cepat) --}}
                <div class="lg:col-span-1 bg-white p-10 rounded-[3rem] shadow-2xl border border-gray-100">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                        <span class="flex h-3 w-3 relative">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                        </span>
                        Akses Cepat
                    </h4>
                    <div class="space-y-3">
                        <a href="{{ route('admin_pac.surat.create') }}" class="block w-full py-4 bg-indigo-700 text-white rounded-2xl text-[10px] font-black uppercase text-center tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-100">
                            Ajukan Surat Keluar
                        </a>
                        <a href="{{ route('admin_pac.anggota.create') }}" class="block w-full py-4 bg-white border-2 border-slate-100 text-slate-600 rounded-2xl text-[10px] font-black uppercase text-center tracking-widest hover:bg-slate-50 transition-all">
                            Input Anggota Baru
                        </a>
                    </div>
                </div>

                {{-- KOLOM KANAN (Daftar Anggota - Lebar 2 Kolom) --}}
                <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-2xl border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-[0.3em]">Anggota Baru Wilayah</h4>
                        <a href="{{ route('admin_pac.anggota.index') }}" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-100 transition-all">Semua Data</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($latest_members as $member)
                        <div class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-colors border border-transparent hover:border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-700 font-black shadow-inner">
                                    {{ substr($member->nama, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-sm tracking-tight">{{ $member->nama }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $member->organisasiUnit->nama }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $member->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>