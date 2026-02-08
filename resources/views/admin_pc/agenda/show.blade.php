<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Agenda Kegiatan</h2>
            <a href="{{ route('admin_pc.agenda.index') }}" class="text-xs font-black text-slate-400 hover:text-emerald-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[3rem] border border-gray-100 overflow-hidden relative">
                {{-- Decorative Line --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-600"></div>
                
                <div class="p-8 md:p-12">
                    <div class="mb-8 border-b border-slate-50 pb-6">
                        <span class="px-3 py-1 bg-orange-50 text-orange-600 text-[10px] font-black rounded-lg uppercase border border-orange-100">{{ $agenda->status }}</span>
                        <h3 class="text-3xl font-black text-slate-800 mt-4 leading-tight">{{ $agenda->nama }}</h3>
                        <p class="text-emerald-600 font-bold uppercase tracking-widest text-sm mt-1">{{ $agenda->organisasiUnit->nama }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-8 border-b border-slate-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-slate-50 rounded-2xl text-2xl">📅</div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Waktu Pelaksanaan</p>
                                <p class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-slate-50 rounded-2xl text-2xl">📍</div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Lokasi Kegiatan</p>
                                <p class="font-bold text-slate-700">{{ $agenda->lokasi }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <p class="text-[10px] text-slate-400 font-black uppercase mb-3 tracking-[0.2em]">Deskripsi / Rencana Kegiatan</p>
                        <div class="bg-slate-50 p-6 rounded-[2rem] text-slate-600 leading-relaxed italic">
                            "{{ $agenda->deskripsi }}"
                        </div>
                    </div>

                    {{-- Tombol Approval (Hanya muncul jika status belum diputuskan) --}}
                    @if($agenda->status == 'permintaan' || $agenda->status == 'pending')
                    <div class="mt-12 p-8 bg-emerald-50 rounded-[2.5rem] border border-emerald-100 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div>
                            <p class="font-black text-emerald-800 uppercase text-xs tracking-widest">Keputusan Admin PC</p>
                            <p class="text-[10px] text-emerald-600 font-medium">Berikan persetujuan untuk agenda ini.</p>
                        </div>
                        <div class="flex gap-4">
                            <form action="{{ route('admin_pc.agenda.status', $agenda->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="diterima">
                                <button type="submit" class="px-8 py-3 bg-emerald-600 text-white rounded-xl font-bold shadow-lg hover:bg-emerald-700 transition transform hover:-translate-y-1">Setujui</button>
                            </form>
                            <form action="{{ route('admin_pc.agenda.status', $agenda->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="px-8 py-3 bg-white text-red-600 border border-red-200 rounded-xl font-bold hover:bg-red-50 transition">Tolak</button>
                            </form>
                        </div>
                    </div>
                    @else
                        <div class="mt-12 text-center">
                            <p class="text-[10px] text-slate-400 font-bold uppercase italic">Agenda ini telah berstatus: {{ $agenda->status }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>