<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Anggota</h2>
            <a href="{{ route('admin_pc.anggota.index') }}" class="text-xs font-black text-slate-400 hover:text-emerald-600 uppercase tracking-widest">&larr; Batal</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-emerald-600"></div>

                <form action="{{ route('admin_pc.anggota.update', $anggota->id) }}" method="POST" class="space-y-8">
                    @csrf @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest border-b border-emerald-50 pb-2">Identitas Dasar</p>
                            <div>
                                <x-input-label value="Nama Lengkap" />
                                <x-text-input name="nama" class="w-full rounded-2xl" :value="old('nama', $anggota->nama)" required />
                            </div>
                            <div>
                                <x-input-label value="NIK (16 Digit)" />
                                <x-text-input name="nik" class="w-full rounded-2xl" :value="old('nik', $anggota->nik)" required />
                            </div>
                            <div>
                                <x-input-label value="Jenis Kelamin" />
                                <select name="kelamin" class="w-full rounded-2xl border-gray-200 font-bold text-sm bg-slate-50">
                                    <option value="L" {{ $anggota->kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $anggota->kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-50 pb-2">Penempatan Struktur</p>
                            <div>
                                <x-input-label value="Jabatan" />
                                <select name="jabatan_id" class="w-full rounded-2xl border-gray-200 font-bold text-sm bg-slate-50">
                                    @foreach($jabatans as $j)
                                        <option value="{{ $j->id }}" {{ $anggota->jabatan_id == $j->id ? 'selected' : '' }}>{{ $j->nama }} ({{ strtoupper($j->level_akses) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label value="Unit Organisasi" />
                                <select name="organisasi_unit_id" class="w-full rounded-2xl border-gray-200 font-bold text-sm bg-slate-50">
                                    @foreach($units as $u)
                                        <option value="{{ $u->id }}" {{ $anggota->organisasi_unit_id == $u->id ? 'selected' : '' }}>{{ $u->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex justify-between items-center">
                        <p class="text-[10px] text-slate-400 font-bold italic">Akun Login: {{ $anggota->user->email }}</p>
                        <x-primary-button class="bg-slate-800 hover:bg-emerald-700 px-10 py-4 rounded-2xl shadow-xl transition-all">
                            Update Data Anggota
                        </x-primary-button>
                    </div>
                </form>

                <div class="mt-4 flex justify-end">
                    <form action="{{ route('admin_pc.anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus anggota akan menghapus akun login mereka juga. Lanjutkan?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs font-black text-red-400 hover:text-red-600 uppercase tracking-widest transition">
                            Hapus Anggota Ini
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>