<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-2 h-6 bg-emerald-600 rounded-full"></div>
            <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">
                {{ __('Tambah Data Pengkaderan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ERROR MESSAGES --}}
            @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li class="text-rose-600 text-sm font-medium">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white shadow-2xl overflow-hidden rounded-[2.5rem] border border-gray-100">
                <form method="POST" action="{{ route('anggota.pengkaderan.store') }}" enctype="multipart/form-data" class="p-8 md:p-10 space-y-6">
                    @csrf

                    {{-- Jenis Pengkaderan --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Jenis Pengkaderan <span class="text-rose-500">*</span></label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('jenis_pengkaderan') border-rose-500 @enderror"
                            type="text" name="jenis_pengkaderan" value="{{ old('jenis_pengkaderan') }}" required placeholder="Contoh: PKSAR, PKDAL, PKPIM">
                        <p class="text-[10px] text-slate-400 ml-1 font-medium italic">*Nama program pengkaderan yang diikuti</p>
                    </div>

                    {{-- Tanggal Pelaksanaan --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Tanggal Pelaksanaan <span class="text-rose-500">*</span></label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('tanggal_pelaksanaan') border-rose-500 @enderror"
                            type="date" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}" required>
                    </div>

                    {{-- Pelaksana --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Pelaksana / Penyelenggara <span class="text-rose-500">*</span></label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('pelaksana') border-rose-500 @enderror"
                            type="text" name="pelaksana" value="{{ old('pelaksana') }}" required placeholder="Contoh: PC GP Ansor Tulungagung">
                        <p class="text-[10px] text-slate-400 ml-1 font-medium italic">*Organisasi atau lembaga yang menyelenggarakan</p>
                    </div>

                    {{-- Nomor Sertifikat --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Nomor Sertifikat (Opsional)</label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('nomor_sertifikat') border-rose-500 @enderror"
                            type="text" name="nomor_sertifikat" value="{{ old('nomor_sertifikat') }}" placeholder="Contoh: 001/PKSAR/2024">
                    </div>

                    {{-- Upload Dokumen --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Upload Sertifikat / Dokumen (Opsional)</label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 @error('url_dokumen') border-rose-500 @enderror"
                            type="file" name="url_dokumen" accept=".pdf,.jpg,.jpeg,.png">
                        <p class="text-[10px] text-slate-400 ml-1 font-medium italic">*Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</p>
                    </div>

                    {{-- FOOTER BUTTONS --}}
                    <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-center gap-4 mt-4">
                        <a href="{{ route('anggota.pengkaderan.index') }}" class="w-full sm:w-auto px-8 py-3 border-2 border-slate-200 text-slate-500 rounded-2xl text-sm font-bold uppercase tracking-widest text-center hover:bg-slate-50 transition-all">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-12 py-3 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-2xl text-sm font-black uppercase tracking-widest shadow-lg shadow-emerald-100 hover:shadow-xl hover:shadow-emerald-200 transform hover:-translate-y-1 active:scale-95 transition-all duration-300">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>