<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Database Pengkaderan') }}
            </h2>
            <span class="px-4 py-1.5 rounded-full bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                Lingkup: Seluruh Wilayah PC
            </span>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- 1. HEADER STATS --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">Data Pelatihan Kader</h3>
                    <p class="text-slate-500 font-medium mt-1">Rekapitulasi riwayat pengkaderan anggota (PKD, PKL, dll).</p>
                </div>

                {{-- Quick Stat --}}
                <div class="bg-white px-5 py-3 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Data</p>
                        <p class="text-xl font-black text-slate-800">{{ $pengkaderans->total() }}</p>
                    </div>
                </div>
            </div>

            {{-- 2. FILTER & SEARCH CARD --}}
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-1">
                <form action="{{ route('admin_pc.pengkaderan.index') }}" method="GET" class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">

                        {{-- Search --}}
                        <div class="md:col-span-3 space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Pencarian</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-semibold text-slate-700 transition-all placeholder:text-slate-400"
                                    placeholder="Nama kader atau jenis...">
                            </div>
                        </div>

                        {{-- Filter PAC --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Filter PAC</label>
                            <select name="pac_id" class="w-full px-4 py-3.5 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer transition-all">
                                <option value="">Semua PAC</option>
                                <option value="{{ auth()->user()->organisasiUnit->id }}" {{ request('pac_id') == auth()->user()->organisasiUnit->id ? 'selected' : '' }}>Pengurus Cabang (PC)</option>
                                @foreach($pacUnits as $pac)
                                <option value="{{ $pac->id }}" {{ request('pac_id') == $pac->id ? 'selected' : '' }}>{{ $pac->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter PR --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Filter PR</label>
                            <select name="pr_id" class="w-full px-4 py-3.5 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer transition-all">
                                <option value="">Semua PR</option>
                                @foreach($prUnits as $pr)
                                <option value="{{ $pr->id }}" {{ request('pr_id') == $pr->id ? 'selected' : '' }}>{{ $pr->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Jenis --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Jenis</label>
                            <select name="jenis" class="w-full px-4 py-3.5 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer transition-all">
                                <option value="">Semua Jenis</option>
                                @foreach($jenisOptions as $jenis)
                                <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Actions --}}
                        <div class="md:col-span-3 flex gap-2">
                            <button type="submit" class="flex-1 py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-sm font-bold shadow-lg transition-all flex items-center justify-center gap-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Filter
                            </button>

                            @if(request()->hasAny(['search', 'pac_id', 'pr_id', 'jenis', 'tanggal_dari', 'tanggal_sampai']))
                            <a href="{{ route('admin_pc.pengkaderan.index') }}" class="px-4 py-3.5 bg-slate-100 text-slate-500 hover:text-slate-700 hover:bg-slate-200 rounded-2xl font-bold transition-all" title="Reset Filter">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Date Range Filter (Collapsible) --}}
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <details class="group">
                            <summary class="cursor-pointer text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-2 hover:text-emerald-600 transition-colors list-none">
                                <span class="bg-slate-100 rounded-lg p-1 group-open:rotate-90 transition-transform">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                                Filter Tanggal Pelaksanaan
                            </summary>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 animate-fade-in-down">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Dari Tanggal</label>
                                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full px-4 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-semibold text-slate-700 transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Sampai Tanggal</label>
                                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full px-4 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-semibold text-slate-700 transition-all">
                                </div>
                            </div>
                        </details>
                    </div>
                </form>
            </div>

            {{-- 3. TABLE CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/40 rounded-[2.5rem] overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-8 py-5 border-b border-slate-100">Anggota</th>
                                <th class="px-6 py-5 border-b border-slate-100">Unit Asal</th>
                                <th class="px-6 py-5 border-b border-slate-100">Jenis & Tanggal</th>
                                <th class="px-6 py-5 border-b border-slate-100">Pelaksana</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($pengkaderans as $p)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-blue-50 flex items-center justify-center text-indigo-600 font-black text-sm shadow-sm group-hover:from-emerald-100 group-hover:to-teal-100 group-hover:text-emerald-700 transition-all border border-indigo-100">
                                            {{ substr($p->anggota->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">{{ $p->anggota->nama }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mt-0.5">{{ optional($p->anggota->jabatan)->nama ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-xs font-bold text-slate-700 uppercase">{{ $p->anggota->organisasiUnit->nama }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded text-[10px] font-black uppercase tracking-wide border border-emerald-100">
                                                {{ $p->jenis_pengkaderan }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-slate-500">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-[10px] font-bold">{{ $p->tanggal_pelaksanaan->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-xs font-medium text-slate-600">{{ $p->pelaksana }}</span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <a href="{{ route('admin_pc.pengkaderan.show', $p->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all text-[10px] font-black uppercase tracking-widest shadow-sm group-hover:shadow-md">
                                        <span>Detail</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 opacity-50">
                                        <div class="p-4 bg-slate-50 rounded-full border border-slate-100">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <p class="text-slate-400 font-bold text-sm">Tidak ada data pengkaderan yang cocok.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($pengkaderans->hasPages())
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $pengkaderans->appends(request()->query())->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>