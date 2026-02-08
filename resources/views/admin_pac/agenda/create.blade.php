<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Buat Agenda Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-indigo-600"></div>

                <form action="{{ route('admin_pac.agenda.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <x-input-label value="Nama Kegiatan" class="font-bold mb-2" />
                                <x-text-input name="nama" class="w-full rounded-2xl bg-slate-50" placeholder="Contoh: PKD Angkatan II" required />
                            </div>
                            <div>
                                <x-input-label value="Tanggal Pelaksanaan" class="font-bold mb-2" />
                                <x-text-input type="date" name="tanggal_mulai" class="w-full rounded-2xl bg-slate-50" required />
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <x-input-label value="Lokasi / Tempat" class="font-bold mb-2" />
                                <x-text-input name="lokasi" class="w-full rounded-2xl bg-slate-50" placeholder="Gedung Serbaguna..." required />
                            </div>
                            <div>
                                <x-input-label value="Unit Penanggung Jawab" class="font-bold mb-2" />
                                <select name="organisasi_unit_id" class="w-full rounded-2xl border-gray-100 font-bold text-sm bg-slate-50 focus:ring-indigo-500">
                                    <option value="{{ Auth::user()->organisasi_unit_id }}">PAC {{ Auth::user()->organisasiUnit->nama }}</option>
                                    @foreach($units as $u)
                                        <option value="{{ $u->id }}">PR {{ $u->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <x-input-label value="Deskripsi / Rencana Acara" class="font-bold mb-2" />
                        <textarea name="deskripsi" rows="4" class="w-full rounded-[2rem] border-gray-100 bg-slate-50 focus:ring-indigo-500 font-medium text-sm" placeholder="Jelaskan detail singkat kegiatan..." required></textarea>
                    </div>

                    <div class="pt-6 flex justify-end">
                        <x-primary-button class="bg-indigo-700 rounded-2xl px-12 py-4 shadow-xl shadow-indigo-100">Ajukan Agenda</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>