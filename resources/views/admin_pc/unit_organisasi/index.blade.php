<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Struktur Organisasi') }}
            </h2>
            <span class="px-4 py-1.5 rounded-full bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                Scope: Wilayah Tulungagung
            </span>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- 1. HEADER STATS --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">Unit Organisasi</h3>
                    <p class="text-slate-500 font-medium mt-1">Kelola data Pimpinan Anak Cabang (PAC) dan Ranting (PR).</p>
                </div>
                <div class="flex gap-3">
                    {{-- Stats PAC --}}
                    <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                            <span class="font-black text-xs">PAC</span>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Kecamatan</p>
                            <p class="text-lg font-black text-slate-800">{{ $totalPac }} <span class="text-xs text-slate-400 font-medium">Unit</span></p>
                        </div>
                    </div>
                    {{-- Stats PR --}}
                    <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3">
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                            <span class="font-black text-xs">PR</span>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Ranting</p>
                            <p class="text-lg font-black text-slate-800">{{ $totalPr }} <span class="text-xs text-slate-400 font-medium">Unit</span></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. FILTER & ACTION CARD --}}
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-1">
                <div class="p-6 md:p-8 flex flex-col lg:flex-row items-end gap-6">
                    
                    {{-- Filter Form --}}
                    <div class="w-full lg:flex-1">
                        <form method="GET" action="{{ route('admin_pc.unit-organisasi.index') }}">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 mb-2 block">Filter Wilayah</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <select name="pac_id" onchange="this.form.submit()" 
                                    class="w-full pl-11 pr-10 py-3.5 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer appearance-none transition-all">
                                    <option value="">Tampilkan Semua Unit</option>
                                    @foreach($allPacs as $pac)
                                        <option value="{{ $pac->id }}" {{ request('pac_id') == $pac->id ? 'selected' : '' }}>Lihat Ranting di Wilayah {{ $pac->nama }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Add Button --}}
                    <div class="w-full lg:w-auto">
                        <a href="{{ route('admin_pc.unit-organisasi.create') }}" class="w-full lg:w-auto flex items-center justify-center gap-2 px-8 py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-sm font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Unit Baru
                        </a>
                    </div>
                </div>
            </div>

            {{-- 3. TABLE CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/40 rounded-[2.5rem] overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-8 py-5 border-b border-slate-100">Identitas Unit</th>
                                <th class="px-6 py-5 border-b border-slate-100 text-center">Tingkatan</th>
                                <th class="px-6 py-5 border-b border-slate-100">Induk Organisasi</th>
                                <th class="px-6 py-5 border-b border-slate-100">Lokasi Wilayah</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($units as $unit)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="font-black text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">{{ $unit->nama }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold mt-1 tracking-wider uppercase bg-slate-100 inline-block px-2 py-0.5 rounded-md">ID: #{{ $unit->id }}</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-block px-3 py-1 {{ $unit->level == 'pac' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100' }} text-[10px] font-black rounded-lg uppercase tracking-widest border shadow-sm">
                                        {{ $unit->level == 'pac' ? 'Kecamatan' : 'Ranting' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-xs font-bold text-slate-600">{{ $unit->parent->nama ?? 'Pimpinan Cabang' }}</div>
                                    <div class="text-[10px] text-slate-400 italic">Atasan Langsung</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-700">{{ $unit->kecamatan->nama ?? '-' }}</div>
                                            @if($unit->desa) 
                                                <div class="text-[10px] text-slate-500 font-medium">{{ $unit->desa->nama }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin_pc.unit-organisasi.edit', $unit->id) }}" class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-lg hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm group-hover:scale-110" title="Edit Unit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $units->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>