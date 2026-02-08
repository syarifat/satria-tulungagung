<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
                <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">
                    {{ __('Detail Pengkaderan') }}
                </h2>
            </div>
            <a href="{{ route('admin_pc.pengkaderan.index') }}" class="flex items-center gap-2 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- MAIN CARD --}}
            <div class="bg-white shadow-2xl overflow-hidden rounded-[2.5rem] border border-gray-100">
                <div class="p-8 md:p-10 space-y-8">

                    {{-- Header --}}
                    <div class="flex items-start gap-4 pb-6 border-b border-gray-100">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-3xl shadow-sm border border-indigo-100">
                            📚
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-black text-slate-800 mb-2">{{ $pengkaderan->jenis_pengkaderan }}</h3>
                            <div class="flex items-center gap-2 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm font-bold">{{ $pengkaderan->tanggal_pelaksanaan->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Anggota Info --}}
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Informasi Anggota</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-emerald-600 font-black text-lg shadow-sm">
                                    {{ substr($pengkaderan->anggota->nama, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Nama Lengkap</p>
                                    <p class="text-lg font-black text-slate-800">{{ $pengkaderan->anggota->nama }}</p>
                                    <p class="text-xs text-slate-500 font-medium mt-1">NIK: {{ $pengkaderan->anggota->nik }}</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Unit Organisasi</p>
                                    <p class="text-sm font-bold text-slate-800 uppercase">{{ $pengkaderan->anggota->organisasiUnit->nama }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Jabatan</p>
                                    <p class="text-sm font-bold text-slate-800 uppercase">{{ optional($pengkaderan->anggota->jabatan)->nama ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Details Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Pelaksana --}}
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Pelaksana</label>
                            </div>
                            <p class="text-lg font-bold text-slate-800 pl-7">{{ $pengkaderan->pelaksana }}</p>
                        </div>

                        {{-- Nomor Sertifikat --}}
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Nomor Sertifikat</label>
                            </div>
                            @if($pengkaderan->nomor_sertifikat)
                            <p class="text-lg font-mono font-bold text-slate-800 pl-7">{{ $pengkaderan->nomor_sertifikat }}</p>
                            @else
                            <p class="text-sm text-slate-400 italic pl-7">Tidak ada nomor sertifikat</p>
                            @endif
                        </div>

                    </div>

                    {{-- Dokumen --}}
                    @if($pengkaderan->url_dokumen)
                    <div class="pt-6 border-t border-gray-100">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Dokumen Sertifikat</label>
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                @php
                                $ext = pathinfo($pengkaderan->url_dokumen, PATHINFO_EXTENSION);
                                @endphp
                                @if($ext === 'pdf')
                                <svg class="w-6 h-6 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 18h12V6h-4V2H4v16zm-2 1V0h12l4 4v16H2v-1z"></path>
                                </svg>
                                @else
                                <svg class="w-6 h-6 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-700">{{ basename($pengkaderan->url_dokumen) }}</p>
                                <p class="text-xs text-slate-400 uppercase">{{ strtoupper($ext) }} File</p>
                            </div>
                            <a href="{{ Storage::url($pengkaderan->url_dokumen) }}" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-sm">
                                Lihat
                            </a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>