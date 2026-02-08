<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Database Anggota') }}
            </h2>
            <span class="px-4 py-1.5 rounded-full bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                Scope: Se-Tulungagung
            </span>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- 1. HEADER STATS & TITLE --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">Data Personil</h3>
                    <p class="text-slate-500 font-medium mt-1">Kelola data anggota, pengurus, dan kader.</p>
                </div>
                <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Terdaftar</p>
                        <p class="text-xl font-black text-slate-800">{{ $anggotas->total() }} <span class="text-sm text-slate-400 font-medium">Orang</span></p>
                    </div>
                </div>
            </div>

            {{-- 2. FILTER CARD (REDESIGNED) --}}
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-1">
                <form action="{{ route('admin_pc.anggota.index') }}" method="GET" class="p-6 md:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">

                        {{-- Search Input (Lebar) --}}
                        <div class="lg:col-span-4 space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Pencarian</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-semibold text-slate-700 transition-all placeholder:text-slate-400"
                                    placeholder="Cari Nama atau NIK...">
                            </div>
                        </div>

                        {{-- Filter PAC --}}
                        <div class="lg:col-span-3 space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Filter PAC</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <select name="pac_id" onchange="this.form.submit()"
                                    class="w-full pl-11 pr-10 py-3.5 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer appearance-none transition-all">
                                    <option value="">Semua Kecamatan</option>
                                    @foreach($allPacs as $pac)
                                    <option value="{{ $pac->id }}" {{ request('pac_id') == $pac->id ? 'selected' : '' }}>{{ $pac->nama }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Filter Ranting --}}
                        <div class="lg:col-span-3 space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Filter Ranting</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <select name="pr_id" {{ empty($prs) ? 'disabled' : '' }}
                                    class="w-full pl-11 pr-10 py-3.5 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer appearance-none transition-all disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed">
                                    <option value="">Semua Desa/Kelurahan</option>
                                    @if(!empty($prs))
                                    @foreach($prs as $pr)
                                    <option value="{{ $pr->id }}" {{ request('pr_id') == $pr->id ? 'selected' : '' }}>{{ $pr->nama }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="lg:col-span-2 flex gap-2">
                            <button type="submit" class="flex-1 py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-sm font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                            </button>

                            <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="flex-none w-12 flex items-center justify-center py-3.5 bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-600 hover:text-white rounded-2xl transition-all duration-200 group" title="Export PDF">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>

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
                                <th class="px-6 py-5 border-b border-slate-100 text-center">Jabatan</th>
                                <th class="px-6 py-5 border-b border-slate-100">Unit Organisasi</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($anggotas as $agt)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center text-emerald-700 font-black shadow-sm group-hover:scale-110 transition-transform">
                                            {{ substr($agt->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">{{ $agt->nama }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">NIK: {{ $agt->nik }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-lg uppercase tracking-widest border border-indigo-100">
                                        {{ $agt->jabatan->nama ?? 'Anggota' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-xs font-bold text-slate-700">{{ $agt->organisasiUnit->nama }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium italic capitalize mt-0.5 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $agt->organisasiUnit->level == 'pac' ? 'bg-orange-400' : 'bg-blue-400' }}"></span>
                                        {{ $agt->organisasiUnit->level == 'pac' ? 'Kecamatan' : 'Ranting Desa' }}
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin_pc.anggota.show', $agt->id) }}"
                                            class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-lg hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all shadow-sm"
                                            title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $anggotas->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>