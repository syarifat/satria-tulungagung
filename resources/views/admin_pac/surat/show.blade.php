<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Detail Pengajuan Surat</h2>
            <a href="{{ route('admin_pac.surat.index') }}" class="text-xs font-black text-slate-400 hover:text-indigo-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[3rem] border border-gray-100 overflow-hidden">
                <div class="p-10 space-y-10">
                    <div class="flex justify-between items-start border-b border-slate-50 pb-8">
                        <div>
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-lg uppercase border border-indigo-100">
                                {{ $surat->indexSurat->kode }}
                            </span>
                            <h3 class="text-3xl font-black text-slate-800 mt-4 leading-tight">{{ $surat->perihal }}</h3>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Status Saat Ini</p>
                            <span class="px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-widest 
                                {{ $surat->status == 'pending' ? 'bg-orange-500 text-white' : 'bg-emerald-600 text-white' }}">
                                {{ $surat->status }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Nomor Surat Resmi</p>
                            <p class="font-bold text-slate-800 text-lg">{{ $surat->nomor_surat ?? 'BELUM TERBIT' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Tanggal Pengajuan</p>
                            <p class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Penerima/Tujuan</p>
                            <p class="font-bold text-slate-700 uppercase">{{ $surat->penerima }}</p>
                        </div>
                    </div>

                    @if($surat->status == 'pending')
                    <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100 flex justify-between items-center">
                        <p class="text-xs text-slate-500 font-medium italic">Anda masih bisa membatalkan pengajuan ini sebelum disetujui PC.</p>
                        <form action="{{ route('admin_pac.surat.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Batalkan pengajuan surat ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs font-black text-red-500 hover:underline uppercase tracking-widest">Batalkan Surat</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>