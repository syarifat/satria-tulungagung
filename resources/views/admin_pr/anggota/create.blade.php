<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Registrasi Kader Baru</h2>
            <a href="{{ route('admin_pr.anggota.index') }}" class="text-xs font-black text-slate-400 hover:text-teal-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                {{-- Decorative Line --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-teal-600"></div>

                <form action="{{ route('admin_pr.anggota.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Sisi Kiri: Identitas --}}
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-teal-600 uppercase tracking-widest border-b border-teal-50 pb-2">Informasi Personal</p>
                            
                            <div>
                                <x-input-label value="Nama Lengkap Kader" />
                                <x-text-input name="nama" class="w-full rounded-2xl bg-slate-50 focus:ring-teal-500" placeholder="Masukkan nama sesuai KTP" required />
                            </div>

                            <div>
                                <x-input-label value="NIK (Nomor Induk Kependudukan)" />
                                <x-text-input name="nik" class="w-full rounded-2xl bg-slate-50" placeholder="16 Digit NIK" required />
                            </div>

                            <div>
                                <x-input-label value="Email" />
                                <x-text-input type="email" name="email" class="w-full rounded-2xl bg-slate-50" placeholder="email@kaderansor.id" required />
                            </div>
                        </div>

                        {{-- Sisi Kanan: Penugasan --}}
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-teal-600 uppercase tracking-widest border-b border-teal-50 pb-2">Struktural Ranting</p>
                            
                            <div>
                                <x-input-label value="Pimpinan Ranting (Otomatis)" />
                                <div class="w-full p-4 rounded-2xl bg-slate-100 font-bold text-slate-500 text-sm border border-slate-200 uppercase">
                                    PR {{ Auth::user()->organisasiUnit->nama }}
                                </div>
                            </div>

                            <div>
                                <x-input-label value="Jabatan di Ranting" />
                                <select name="jabatan_id" class="w-full rounded-2xl border-gray-100 font-bold text-sm bg-slate-50 focus:ring-teal-500">
                                    @foreach($jabatans as $j)
                                        <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="p-6 bg-orange-50 rounded-2xl border border-orange-100">
                                <p class="text-[10px] text-orange-700 font-bold leading-relaxed italic uppercase">
                                    * Password default untuk anggota baru adalah: <span class="font-black">ansor123</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-50 flex justify-end">
                        <x-primary-button class="bg-teal-700 hover:bg-teal-800 rounded-2xl px-12 py-4 shadow-xl transition-all hover:-translate-y-1">
                            Simpan Kader Baru
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>