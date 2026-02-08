<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Update Master Jabatan') }}
            </h2>
            <a href="{{ route('admin_pc.jabatan.index') }}" class="text-xs font-black text-slate-400 hover:text-emerald-600 transition-colors uppercase tracking-widest flex items-center gap-1">
                &larr; Batal & Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                {{-- Decorative Header Gradient --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-indigo-600"></div>

                <div class="mb-8 border-b border-gray-50 pb-6">
                    <h3 class="text-2xl font-black text-slate-800 mb-1">
                        {{ $jabatan->nama }}
                    </h3>
                    <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Edit Konfigurasi Jabatan</p>
                </div>

                <form action="{{ route('admin_pc.jabatan.update', $jabatan->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest border-b border-emerald-50 pb-2">Informasi Jabatan</p>
                        
                        <div>
                            <x-input-label value="Nama Jabatan" class="font-bold text-slate-700 mb-1" />
                            <x-text-input name="nama" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold" :value="old('nama', $jabatan->nama)" required />
                        </div>

                        <div>
                            <x-input-label value="Akses Tingkatan" class="font-bold text-slate-700 mb-3" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach(['all' => 'Semua Level', 'pc' => 'Hanya PC', 'pac' => 'Hanya PAC', 'pr' => 'Hanya PR'] as $val => $label)
                                <label class="flex items-center p-4 border rounded-2xl cursor-pointer hover:bg-emerald-50 transition-all has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500 {{ $jabatan->level_akses == $val ? 'bg-emerald-50 border-emerald-500' : 'border-gray-200' }}">
                                    <input type="radio" name="level_akses" value="{{ $val }}" class="text-emerald-600 focus:ring-emerald-500" {{ old('level_akses', $jabatan->level_akses) == $val ? 'checked' : '' }}>
                                    <span class="ml-2 text-xs font-bold text-slate-600 uppercase tracking-wide">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                            <p class="text-[10px] text-slate-400 mt-4 font-medium italic">
                                * Perubahan akses akan mempengaruhi ketersediaan jabatan ini saat pendaftaran anggota baru di level tertentu.
                            </p>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-xs text-slate-400 font-medium italic">Data terakhir diubah: {{ $jabatan->updated_at->format('d M Y H:i') }}</p>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 px-12 py-4 rounded-2xl shadow-xl transition-all hover:-translate-y-1">
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>