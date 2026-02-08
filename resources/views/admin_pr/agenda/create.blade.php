<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Laporkan Kegiatan Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-teal-600"></div>

                <form action="{{ route('admin_pr.agenda.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <x-input-label value="Nama Kegiatan" class="font-bold mb-2" />
                                <x-text-input name="nama" class="w-full rounded-2xl bg-slate-50" placeholder="Misal: Rapat Anggota Ranting" required />
                            </div>
                            <div>
                                <x-input-label value="Tanggal" class="font-bold mb-2" />
                                <x-text-input type="date" name="tanggal_mulai" class="w-full rounded-2xl bg-slate-50" required />
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <x-input-label value="Lokasi" class="font-bold mb-2" />
                                <x-text-input name="lokasi" class="w-full rounded-2xl bg-slate-50" placeholder="Nama Masjid/Gedung..." required />
                            </div>
                            <div>
                                <x-input-label value="Unit (Otomatis)" class="font-bold mb-2" />
                                <div class="w-full p-4 rounded-2xl bg-slate-100 font-bold text-slate-500 text-sm border border-slate-200">
                                    PR {{ Auth::user()->organisasiUnit->nama }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <x-input-label value="Keterangan Kegiatan" class="font-bold mb-2" />
                        <textarea name="deskripsi" rows="4" class="w-full rounded-[2rem] border-gray-100 bg-slate-50 focus:ring-teal-500 font-medium text-sm" placeholder="Jelaskan ringkasan rencana kegiatan..." required></textarea>
                    </div>

                    <div class="pt-6 flex justify-end">
                        <x-primary-button class="bg-teal-700 rounded-2xl px-12 py-4 shadow-xl">Kirim Laporan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>