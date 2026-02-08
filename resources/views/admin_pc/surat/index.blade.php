<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Manajemen Surat') }}
            </h2>
            <span class="px-4 py-1.5 rounded-full bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                Approval & Arsip
            </span>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- 1. HEADER STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Menunggu Persetujuan</p>
                        <p class="text-3xl font-black text-orange-500">{{ $surats->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Telah Disetujui</p>
                        <p class="text-3xl font-black text-emerald-500">{{ $surats->where('status', 'diterima')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Ditolak / Revisi</p>
                        <p class="text-3xl font-black text-rose-500">{{ $surats->where('status', 'ditolak')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- 2. FILTER & SEARCH (Optional, bisa diaktifkan jika perlu) --}}
            {{-- <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-1">
                <form ... class="p-6"> ... </form>
            </div> --}}

            {{-- 3. TABLE CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/40 rounded-[2.5rem] overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-8 py-5 border-b border-slate-100">Informasi Surat</th>
                                <th class="px-6 py-5 border-b border-slate-100">Asal Pengirim</th>
                                <th class="px-6 py-5 border-b border-slate-100 text-center">Status</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($surats as $s)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="font-black text-slate-800 text-sm group-hover:text-emerald-700 transition-colors mb-1">{{ $s->perihal }}</div>
                                    <div class="flex items-center gap-2">
                                        <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border border-slate-200">
                                            No: {{ $s->nomor_surat ?? 'Draft' }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-medium">
                                            {{ $s->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-xs border border-indigo-100 shrink-0">
                                            {{ substr($s->organisasiUnit->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-700">{{ $s->organisasiUnit->nama }}</div>
                                            <div class="text-[10px] text-slate-400 font-medium mt-0.5">Kode: {{ $s->indexSurat->kode }}</div>
                                        </div>
                                    </div>
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
                                        <span>{{ $statusIcon }}</span> {{ $s->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <a href="{{ route('admin_pc.surat.show', $s->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                        <span>Review</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold">
                                    Tidak ada data surat untuk ditampilkan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $surats->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>