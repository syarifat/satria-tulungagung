<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Struktur Organisasi') }}
            </h2>
            <span class="px-4 py-1.5 rounded-full bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                Wilayah Pimpinan Anak Cabang
            </span>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- 1. HEADER STATS --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">Daftar Pimpinan Ranting</h3>
                    <p class="text-slate-500 font-medium mt-1">Data unit PR di bawah koordinasi PAC.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    {{-- Stats Card --}}
                    <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Ranting</p>
                            <p class="text-xl font-black text-slate-800">{{ $rantings->count() }} <span class="text-xs text-slate-400 font-medium">Unit</span></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. TABLE CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/40 rounded-[2.5rem] overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-8 py-5 border-b border-slate-100">Identitas Ranting</th>
                                <th class="px-6 py-5 border-b border-slate-100">Wilayah Desa</th>
                                <th class="px-6 py-5 border-b border-slate-100 text-center">Jumlah Anggota</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($rantings as $r)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-blue-50 flex items-center justify-center text-indigo-600 font-black shadow-sm group-hover:scale-110 transition-transform text-xs border border-indigo-100">
                                            PR
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 text-sm group-hover:text-indigo-700 transition-colors">{{ $r->nama }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">ID: #{{ $r->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2 text-slate-600">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="text-xs font-bold uppercase">{{ $r->desa->nama ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg text-[11px] font-black border border-slate-200">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        {{ $r->anggotas->count() }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                        {{-- Detail Button --}}
                                        <a href="{{ route('admin_pac.ranting.show', $r->id) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all shadow-sm group-hover:scale-105" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        {{-- Edit Button --}}
                                        <a href="{{ route('admin_pac.ranting.edit', $r->id) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm group-hover:scale-105" title="Edit Data">
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
                {{-- Pagination Placeholder (Jika ada) --}}
                {{-- <div class="p-6 bg-slate-50 border-t border-slate-100">{{ $rantings->links() }}</div> --}}
            </div>
        </div>
    </div>
</x-app-layout>