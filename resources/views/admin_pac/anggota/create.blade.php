<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Input Anggota Baru Wilayah</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-indigo-600"></div>
                <form action="{{ route('admin_pac.anggota.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b pb-2">Data Diri</p>
                            <div>
                                <x-input-label value="Nama Lengkap" />
                                <x-text-input name="nama" class="w-full rounded-2xl bg-slate-50" required />
                            </div>
                            <div>
                                <x-input-label value="NIK (16 Digit)" />
                                <x-text-input name="nik" class="w-full rounded-2xl bg-slate-50" required />
                            </div>
                            <div>
                                <x-input-label value="Email Aktif" />
                                <x-text-input type="email" name="email" class="w-full rounded-2xl bg-slate-50" required />
                            </div>
                        </div>
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b pb-2">Struktural</p>
                            <div>
                                <x-input-label value="Unit Penempatan" />
                                <select name="organisasi_unit_id" class="w-full rounded-2xl border-gray-100 font-bold text-sm bg-slate-50">
                                    <option value="{{ Auth::user()->organisasi_unit_id }}">PAC {{ Auth::user()->organisasiUnit->nama }}</option>
                                    @foreach($rantings as $r)
                                        <option value="{{ $r->id }}">PR {{ $r->nama }} (Ranting)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label value="Jabatan" />
                                <select name="jabatan_id" class="w-full rounded-2xl border-gray-100 font-bold text-sm bg-slate-50">
                                    @foreach($jabatans as $j)
                                        <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="pt-6 flex justify-end">
                        <x-primary-button class="bg-indigo-700 rounded-2xl px-12 py-4 shadow-xl shadow-indigo-100">Simpan Anggota</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>