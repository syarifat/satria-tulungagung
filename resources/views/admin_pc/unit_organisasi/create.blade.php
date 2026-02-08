<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrasi Unit Organisasi</h2>
            <a href="{{ route('admin_pc.unit-organisasi.index') }}" class="text-xs font-black text-slate-400 hover:text-emerald-600 transition-colors uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-indigo-600"></div>

                <form action="{{ route('admin_pc.unit-organisasi.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Data Dasar --}}
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest border-b border-emerald-50 pb-2">Identitas Unit</p>
                            
                            <div>
                                <x-input-label value="Nama Unit Organisasi" class="font-bold text-slate-700 mb-1" />
                                <x-text-input name="nama" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold" placeholder="Contoh: PAC Boyolangu" required />
                            </div>

                            <div>
                                <x-input-label value="Tingkatan" class="font-bold text-slate-700 mb-1" />
                                <select name="level" id="level_select" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold text-sm bg-slate-50" required onchange="togglePRSection()">
                                    <option value="pac">Pimpinan Anak Cabang (PAC)</option>
                                    <option value="pr">Pimpinan Ranting (PR)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Data Wilayah --}}
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-50 pb-2">Wilayah Kerja</p>
                            
                            <div>
                                <x-input-label value="Pilih Kecamatan" class="font-bold text-slate-700 mb-1" />
                                <select name="kecamatan_id" id="kecamatan_id" class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 font-bold text-sm bg-slate-50">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach($kecamatans as $kec)
                                        <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="pr_fields" class="hidden space-y-6 animate-fade-in">
                                <div>
                                    <x-input-label value="Pilih Desa" class="font-bold text-slate-700 mb-1" />
                                    <select name="desa_id" id="desa_id" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold text-sm bg-slate-50">
                                        <option value="">-- Pilih Desa --</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label value="Unit Induk (PAC)" class="font-bold text-slate-700 mb-1" />
                                    <select name="parent_id" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold text-sm">
                                        @foreach($pacs as $pac)
                                            <option value="{{ $pac->id }}">{{ $pac->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex justify-end">
                        <x-primary-button class="bg-slate-800 hover:bg-slate-900 px-10 py-4 rounded-2xl shadow-xl transition-all hover:-translate-y-1">
                            Daftarkan Unit
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('kecamatan_id').addEventListener('change', function() {
            const kecId = this.value;
            const desaSelect = document.getElementById('desa_id');
            
            // Bersihkan dropdown desa dan tampilkan loading
            desaSelect.innerHTML = '<option value="">-- Memuat Desa... --</option>';

            if (kecId) {
                // Panggil route yang baru saja kita buat
                fetch(`/api/wilayah/desa/${kecId}`)
                    .then(response => response.json())
                    .then(data => {
                        desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
                        data.forEach(desa => {
                            desaSelect.innerHTML += `<option value="${desa.id}">${desa.nama}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        desaSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    });
            } else {
                desaSelect.innerHTML = '<option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>';
            }
        });
    </script>
    @endpush
</x-app-layout>