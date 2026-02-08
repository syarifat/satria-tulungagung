<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Formulir Pengajuan Surat</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-indigo-600"></div>

                <form action="{{ route('admin_pac.surat.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <x-input-label value="Pilih Index / Kode Surat" class="font-bold text-slate-700 mb-2" />
                                <select name="index_surat_id" class="w-full rounded-2xl border-gray-100 font-bold text-sm bg-slate-50 focus:ring-indigo-500">
                                    @foreach($indexes as $idx)
                                        <option value="{{ $idx->id }}">[{{ $idx->kode }}] {{ $idx->deskripsi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label value="Tanggal Surat" class="font-bold text-slate-700 mb-2" />
                                <x-text-input type="date" name="tanggal_surat" class="w-full rounded-2xl bg-slate-50" required />
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <x-input-label value="Perihal (Judul Surat)" class="font-bold text-slate-700 mb-2" />
                                <x-text-input name="perihal" class="w-full rounded-2xl bg-slate-50" placeholder="Contoh: Undangan Rapat Pleno" required />
                            </div>
                            <div>
                                <x-input-label value="Ditujukan Kepada" class="font-bold text-slate-700 mb-2" />
                                <x-text-input name="penerima" class="w-full rounded-2xl bg-slate-50" placeholder="Nama instansi/perorangan" required />
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex justify-between items-center">
                        <p class="text-[10px] text-slate-400 font-bold italic">* Nomor surat akan otomatis muncul setelah disetujui PC.</p>
                        <x-primary-button class="bg-indigo-700 rounded-2xl px-12 py-4 shadow-xl">Kirim ke PC</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>