<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Detail Surat Ranting</h2>
            <a href="{{ route('admin_pr.surat.index') }}" class="text-xs font-black text-slate-400 hover:text-teal-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[3rem] border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-teal-600"></div>
                
                <div class="p-10 md:p-16 space-y-10">
                    <div class="flex justify-between items-start border-b border-slate-50 pb-8">
                        <div>
                            <span class="px-3 py-1 bg-teal-50 text-teal-700 text-[10px] font-black rounded-lg uppercase border border-teal-100">
                                {{ $surat->indexSurat->kode }}
                            </span>
                            <h3 class="text-3xl font-black text-slate-800 mt-6 leading-tight">{{ $surat->perihal }}</h3>
                        </div>
                        <span class="px-4 py-2 bg-slate-800 text-white rounded-2xl text-xs font-black uppercase tracking-widest">{{ $surat->status }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Nomor Surat Resmi</p>
                            <p class="font-bold text-slate-700 text-lg">{{ $surat->nomor_surat ?? 'Menunggu Verifikasi...' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase mb-1">Tujuan Surat</p>
                            <p class="font-bold text-slate-700 text-lg uppercase">{{ $surat->penerima }}</p>
                        </div>
                    </div>

                    <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 text-center">
                        <p class="text-xs text-slate-500 font-medium italic">"Silakan hubungi Admin PAC atau PC untuk percepatan penomoran surat resmi."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>