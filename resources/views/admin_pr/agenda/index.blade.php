<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Kegiatan Ranting</h2>
            <a href="{{ route('admin_pr.agenda.create') }}" class="px-6 py-2.5 bg-teal-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-teal-100">+ Tambah Kegiatan</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($agendas as $a)
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 hover:border-teal-500 transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 bg-teal-50 text-teal-600 text-[9px] font-black rounded-lg uppercase tracking-widest border border-teal-100">
                            {{ $a->status }}
                        </span>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">
                            {{ \Carbon\Carbon::parse($a->tanggal_mulai)->format('d M Y') }}
                        </p>
                    </div>
                    
                    <h4 class="font-black text-slate-800 text-lg mb-2 group-hover:text-teal-700 transition-colors">
                        {{ $a->nama }}
                    </h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">📍 {{ $a->lokasi }}</p>
                    
                    <div class="pt-5 border-t border-slate-50 flex justify-end">
                        <a href="{{ route('admin_pr.agenda.show', $a->id) }}" class="text-[10px] font-black text-teal-600 hover:underline uppercase tracking-widest">Detail Laporan &rarr;</a>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white p-20 rounded-[3rem] text-center border-2 border-dashed border-slate-100">
                    <p class="text-slate-400 font-bold italic">Belum ada agenda kegiatan di Ranting ini.</p>
                </div>
                @endforelse
            </div>
            <div class="mt-10">{{ $agendas->links() }}</div>
        </div>
    </div>
</x-app-layout>