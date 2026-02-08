<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-2 h-6 bg-orange-600 rounded-full"></div>
            <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">
                {{ __('Edit Data Pengkaderan') }}
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
                <form method="POST" action="{{ route('anggota.pengkaderan.update', $pengkaderan->id) }}" enctype="multipart/form-data" class="p-8 md:p-10 space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Jenis Pengkaderan --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Jenis Pengkaderan <span class="text-rose-500">*</span></label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('jenis_pengkaderan') border-rose-500 @enderror"
                            type="text" name="jenis_pengkaderan" value="{{ old('jenis_pengkaderan', $pengkaderan->jenis_pengkaderan) }}" required placeholder="Contoh: PKSAR, PKDAL, PKPIM">
                    </div>

                    {{-- Tanggal Pelaksanaan --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Tanggal Pelaksanaan <span class="text-rose-500">*</span></label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('tanggal_pelaksanaan') border-rose-500 @enderror"
                            type="date" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', $pengkaderan->tanggal_pelaksanaan->format('Y-m-d')) }}" required>
                    </div>

                    {{-- Pelaksana --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Pelaksana / Penyelenggara <span class="text-rose-500">*</span></label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('pelaksana') border-rose-500 @enderror"
                            type="text" name="pelaksana" value="{{ old('pelaksana', $pengkaderan->pelaksana) }}" required placeholder="Contoh: PC GP Ansor Tulungagung">
                    </div>

                    {{-- Nomor Sertifikat --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Nomor Sertifikat (Opsional)</label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all @error('nomor_sertifikat') border-rose-500 @enderror"
                            type="text" name="nomor_sertifikat" value="{{ old('nomor_sertifikat', $pengkaderan->nomor_sertifikat) }}" placeholder="Contoh: 001/PKSAR/2024">
                    </div>

                    {{-- Current Document --}}
                    @if($pengkaderan->url_dokumen)
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">Dokumen Saat Ini</label>
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <a href="{{ Storage::url($pengkaderan->url_dokumen) }}" target="_blank" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 underline">
                                Lihat Dokumen
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Upload Dokumen --}}
                    <div class="space-y-2">
                        <label class="block font-bold text-xs text-slate-700 ml-1">{{ $pengkaderan->url_dokumen ? 'Ganti' : 'Upload' }} Sertifikat / Dokumen (Opsional)</label>
                        <input class="block w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 rounded-xl shadow-sm py-3 px-4 text-sm font-medium transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 @error('url_dokumen') border-rose-500 @enderror"
                            type="file" name="url_dokumen" accept=".pdf,.jpg,.jpeg,.png">
                        <p class="text-[10px] text-slate-400 ml-1 font-medium italic">*Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</p>
                    </div>

                    {{-- FOOTER BUTTONS --}}
                    <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-center gap-4 mt-4">
                        <a href="{{ route('anggota.pengkaderan.index') }}" class="w-full sm:w-auto px-8 py-3 border-2 border-slate-200 text-slate-500 rounded-2xl text-sm font-bold uppercase tracking-widest text-center hover:bg-slate-50 transition-all">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-12 py-3 bg-orange-600 hover:bg-orange-700 active:bg-orange-800 text-white rounded-2xl text-sm font-black uppercase tracking-widest shadow-lg shadow-orange-100 hover:shadow-xl hover:shadow-orange-200 transform hover:-translate-y-1 active:scale-95 transition-all duration-300">
                            Update Data
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>