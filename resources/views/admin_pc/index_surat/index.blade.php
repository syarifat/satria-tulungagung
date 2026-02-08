<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Master Data') }}
            </h2>
            <span class="px-4 py-1.5 rounded-full bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                Index Surat
            </span>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- 1. HEADER STATS & ACTION --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">Kode Index Surat</h3>
                    <p class="text-slate-500 font-medium mt-1">Daftar kode klasifikasi surat masuk dan keluar organisasi.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    {{-- Stats --}}
                    <div class="hidden md:flex items-center gap-3 px-5 py-2 bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Kategori</p>
                            <p class="text-lg font-black text-slate-800">{{ $indexes->count() }}</p>
                        </div>
                    </div>

                    {{-- Add Button --}}
                    <a href="{{ route('admin_pc.index-surat.create') }}" class="flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Index
                    </a>
                </div>
            </div>

            {{-- 2. TABLE CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/40 rounded-[2.5rem] overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-8 py-5 border-b border-slate-100 w-32">Kode</th>
                                <th class="px-6 py-5 border-b border-slate-100">Deskripsi / Perihal</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($indexes as $idx)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="px-8 py-5">
                                    <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg font-black text-sm border border-emerald-100 shadow-sm">
                                        {{ $idx->kode }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-slate-700 text-sm group-hover:text-emerald-700 transition-colors">
                                        {{ $idx->deskripsi }}
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex justify-center gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin_pc.index-surat.edit', $idx->id) }}" class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-lg hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('admin_pc.index-surat.destroy', $idx->id) }}" method="POST" onsubmit="return confirm('Hapus index surat ini?')">
                                            @csrf @method('DELETE')
                                            <button class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-lg hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination (Optional jika data banyak) --}}
                {{-- <div class="p-6 bg-slate-50 border-t border-slate-100">{{ $indexes->links() }}</div> --}}
            </div>
        </div>
    </div>
</x-app-layout>