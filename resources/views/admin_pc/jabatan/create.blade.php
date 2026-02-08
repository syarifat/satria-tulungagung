<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Master Jabatan</h2>
            <a href="{{ route('admin_pc.jabatan.index') }}" class="text-xs font-black text-slate-400 hover:text-emerald-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-600"></div>

                <form action="{{ route('admin_pc.jabatan.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest border-b border-emerald-50 pb-2">Detail Jabatan Baru</p>
                        
                        <div>
                            <x-input-label value="Nama Jabatan" class="font-bold text-slate-700 mb-1" />
                            <x-text-input name="nama" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold" placeholder="Contoh: Ketua, Kasatkorcab, dll" required />
                        </div>

                        <div>
                            <x-input-label value="Dapat Dipilih Oleh Level" class="font-bold text-slate-700 mb-3" />
                            <div class="grid grid-cols-2 gap-4">
                                @foreach(['all' => 'Semua Level', 'pc' => 'Hanya PC', 'pac' => 'Hanya PAC', 'pr' => 'Hanya PR'] as $val => $label)
                                <label class="flex items-center p-4 border rounded-2xl cursor-pointer hover:bg-emerald-50 transition-all has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500">
                                    <input type="radio" name="level_akses" value="{{ $val }}" class="text-emerald-600 focus:ring-emerald-500" {{ $val == 'all' ? 'checked' : '' }}>
                                    <span class="ml-2 text-xs font-bold text-slate-600 uppercase tracking-wide">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex justify-end">
                        <x-primary-button class="bg-slate-800 hover:bg-slate-900 px-10 py-4 rounded-2xl shadow-xl transition-all hover:-translate-y-1">
                            Simpan Jabatan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>