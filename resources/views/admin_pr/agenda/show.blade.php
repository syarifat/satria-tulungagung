<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Detail Kegiatan</h2>
            <a href="{{ route('admin_pr.agenda.index') }}" class="text-xs font-black text-slate-400 hover:text-teal-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[3rem] border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-teal-600"></div>
                
                <div class="p-10 md:p-16 space-y-10">
                    <div class="border-b border-slate-50 pb-8">
                        <span class="px-3 py-1 bg-teal-50 text-teal-700 text-[10px] font-black rounded-lg uppercase border border-teal-100">{{ $agenda->status }}</span>
                        <h3 class="text-3xl font-black text-slate-800 mt-6 leading-tight">{{ $agenda->nama }}</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-xl">📅</div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Waktu Pelaksanaan</p>
                                <p class="font-bold text-slate-700 text-lg">{{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-xl">📍</div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Tempat</p>
                                <p class="font-bold text-slate-700 text-lg">{{ $agenda->lokasi }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-black uppercase mb-4 tracking-widest">Deskripsi / Hasil Kegiatan</p>
                        <p class="text-slate-600 leading-relaxed font-medium italic">"{{ $agenda->deskripsi }}"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>