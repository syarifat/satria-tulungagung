<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Index Surat</h2>
            <a href="{{ route('admin_pc.index-surat.index') }}" class="text-xs font-black text-slate-400 hover:text-emerald-600 transition-colors uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-indigo-600"></div>

                <form action="{{ route('admin_pc.index-surat.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest border-b border-emerald-50 pb-2">Detail Kode Persuratan</p>
                        
                        <div>
                            <x-input-label value="Kode Index (Misal: A-I, B-II)" class="font-bold text-slate-700 mb-1" />
                            <x-text-input name="kode" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-black text-emerald-700 uppercase" placeholder="A-I" required />
                        </div>

                        <div>
                            <x-input-label value="Deskripsi / Perihal" class="font-bold text-slate-700 mb-1" />
                            <x-text-input name="deskripsi" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold" placeholder="Contoh: Surat Keputusan (SK)" required />
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex justify-end">
                        <x-primary-button class="bg-slate-800 hover:bg-slate-900 px-10 py-4 rounded-2xl shadow-xl transition-all hover:-translate-y-1">
                            Simpan Index
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>