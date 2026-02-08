<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Perbarui Data Kader</h2>
            <a href="{{ route('admin_pr.anggota.index') }}" class="text-xs font-black text-slate-400 hover:text-teal-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-orange-500"></div>

                <form action="{{ route('admin_pr.anggota.update', $anggota->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-teal-600 uppercase tracking-widest border-b border-teal-50 pb-2">Identitas Kader</p>
                            <div>
                                <x-input-label value="Nama Lengkap" />
                                <x-text-input name="nama" class="w-full rounded-2xl bg-slate-50" :value="old('nama', $anggota->nama)" required />
                            </div>
                            <div>
                                <x-input-label value="NIK" />
                                <x-text-input name="nik" class="w-full rounded-2xl bg-slate-50" :value="old('nik', $anggota->nik)" required />
                            </div>
                        </div>

                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-teal-600 uppercase tracking-widest border-b border-teal-50 pb-2">Struktural</p>
                            <div>
                                <x-input-label value="Pimpinan Ranting" />
                                <div class="w-full p-4 rounded-2xl bg-slate-100 font-bold text-slate-400 text-sm border border-slate-200">
                                    PR {{ Auth::user()->organisasiUnit->nama }}
                                </div>
                            </div>
                            <div>
                                <x-input-label value="Jabatan" />
                                <select name="jabatan_id" class="w-full rounded-2xl border-gray-100 font-bold text-sm bg-slate-50 focus:ring-teal-500">
                                    @foreach($jabatans as $j)
                                        <option value="{{ $j->id }}" {{ $anggota->jabatan_id == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-50 flex justify-end">
                        <x-primary-button class="bg-teal-700 hover:bg-teal-800 rounded-2xl px-12 py-4 shadow-xl shadow-teal-100">
                            Update Data Kader
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>