<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Arsip Surat Desa</h2>
            <a href="{{ route('admin_pr.surat.create') }}" class="px-6 py-2.5 bg-teal-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-teal-100">+ Buat Pengajuan</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                            <th class="px-8 py-5 border-b border-slate-100">Perihal</th>
                            <th class="px-6 py-5 border-b border-slate-100">Kode Index</th>
                            <th class="px-6 py-5 border-b border-slate-100 text-center">Status</th>
                            <th class="px-8 py-5 border-b border-slate-100 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($surats as $s)
                        <tr class="hover:bg-teal-50/30 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="font-black text-slate-800 text-sm group-hover:text-teal-700">{{ $s->perihal }}</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase">Tujuan: {{ $s->penerima }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-xs font-black text-teal-600">{{ $s->indexSurat->kode }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-tighter 
                                    {{ $s->status == 'pending' ? 'bg-orange-100 text-orange-600' : 'bg-emerald-100 text-emerald-600' }}">
                                    {{ $s->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <a href="{{ route('admin_pr.surat.show', $s->id) }}" class="p-2 inline-block bg-slate-100 text-slate-400 rounded-xl hover:bg-teal-600 hover:text-white transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-slate-400 italic font-bold">Belum ada pengajuan surat dari Ranting.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>