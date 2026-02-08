<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Buat Pengajuan Surat Keluar</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-teal-600"></div>

                <form action="{{ route('admin_pr.surat.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label value="Index Surat" class="font-bold mb-2" />
                            <select name="index_surat_id" class="w-full rounded-2xl border-gray-100 font-bold text-sm bg-slate-50">
                                @foreach($indexes as $idx)
                                    <option value="{{ $idx->id }}">[{{ $idx->kode }}] {{ $idx->deskripsi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label value="Tanggal Surat" class="font-bold mb-2" />
                            <x-text-input type="date" name="tanggal_surat" class="w-full rounded-2xl bg-slate-50" required />
                        </div>
                    </div>

                    <div>
                        <x-input-label value="Perihal / Judul Surat" class="font-bold mb-2" />
                        <x-text-input name="perihal" class="w-full rounded-2xl bg-slate-50" placeholder="Contoh: Undangan Rapat Anggota" required />
                    </div>

                    <div>
                        <x-input-label value="Penerima / Tujuan" class="font-bold mb-2" />
                        <x-text-input name="penerima" class="w-full rounded-2xl bg-slate-50" placeholder="Contoh: Seluruh Anggota Ranting" required />
                    </div>

                    <div class="pt-6 flex justify-end">
                        <x-primary-button class="bg-teal-700 rounded-2xl px-12 py-4 shadow-xl">Ajukan Surat</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>