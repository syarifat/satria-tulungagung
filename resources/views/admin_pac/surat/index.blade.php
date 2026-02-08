<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Arsip Surat') }}
            </h2>
            <a href="{{ route('admin_pac.surat.create') }}" class="flex items-center gap-2 px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Ajukan Surat
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- 1. SUMMARY STATS (Optional but good for overview) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Arsip</p>
                        <p class="text-xl font-black text-slate-800">{{ $surats->total() }}</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Menunggu</p>
                        <p class="text-xl font-black text-slate-800">{{ $surats->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Disetujui</p>
                        <p class="text-xl font-black text-slate-800">{{ $surats->where('status', 'diterima')->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- 2. TABLE CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/40 rounded-[2.5rem] overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-8 py-5 border-b border-slate-100">Perihal & Tujuan</th>
                                <th class="px-6 py-5 border-b border-slate-100">Nomor Surat</th>
                                <th class="px-6 py-5 border-b border-slate-100 text-center">Status</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($surats as $s)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="font-black text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">{{ $s->perihal }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">Kepada:</span>
                                        <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-[10px] font-bold">{{ $s->penerima }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if($s->nomor_surat)
                                        <span class="text-xs font-bold text-slate-700 bg-slate-50 px-3 py-1 rounded-lg border border-slate-200">
                                            {{ $s->nomor_surat }}
                                        </span>
                                    @else
                                        <span class="text-xs font-medium text-slate-400 italic flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Menunggu Cabang...
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusClass = match($s->status) {
                                            'pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                            'diterima' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'ditolak' => 'bg-rose-50 text-rose-600 border-rose-100',
                                            default => 'bg-slate-50 text-slate-600 border-slate-100',
                                        };
                                        $statusIcon = match($s->status) {
                                            'pending' => '⏳',
                                            'diterima' => '✅',
                                            'ditolak' => '❌',
                                            default => '❓',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $statusClass }}">
                                        {{ $statusIcon }} {{ $s->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <a href="{{ route('admin_pac.surat.show', $s->id) }}" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-800 text-[10px] font-black uppercase tracking-widest transition-colors group-hover:underline decoration-2 underline-offset-4">
                                        Lihat Detail 
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 opacity-50">
                                        <div class="p-4 bg-slate-50 rounded-full">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold text-sm">Belum ada riwayat pengajuan surat.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50 border-t border-slate-100">{{ $surats->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>