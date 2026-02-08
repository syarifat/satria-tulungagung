<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Surat</h2>
            <a href="{{ route('admin_pc.surat.index') }}" class="text-xs font-black text-slate-400 hover:text-emerald-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[3rem] border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-12 space-y-8">
                    <div class="flex justify-between items-start border-b border-slate-100 pb-6">
                        <div>
                            <h3 class="text-2xl font-black text-slate-800">{{ $surat->perihal }}</h3>
                            <p class="text-sm font-bold text-emerald-600 uppercase">{{ $surat->organisasiUnit->nama }}</p>
                        </div>
                        <span class="px-4 py-2 bg-slate-100 rounded-2xl text-[10px] font-black uppercase tracking-widest">{{ $surat->status }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Nomor Surat</p>
                            <p class="font-bold text-slate-700">{{ $surat->nomor_surat ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Tanggal Surat</p>
                            <p class="font-bold text-slate-700">{{ $surat->tanggal_surat }}</p>
                        </div>
                    </div>

                    @if($surat->status == 'pending')
                    <div class="bg-slate-50 p-8 rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col items-center gap-4">
                        <p class="font-black text-slate-600 uppercase text-xs tracking-widest">Keputusan Admin Cabang</p>
                        <div class="flex gap-4">
                            <form action="{{ route('admin_pc.surat.status', $surat->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="diterima">
                                <button type="submit" class="px-8 py-3 bg-emerald-600 text-white rounded-xl font-bold shadow-lg hover:bg-emerald-700 transition">Setujui Surat</button>
                            </form>
                            <form action="{{ route('admin_pc.surat.status', $surat->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="px-8 py-3 bg-red-500 text-white rounded-xl font-bold shadow-lg hover:bg-red-600 transition">Tolak</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>