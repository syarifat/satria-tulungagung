<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Update Unit Organisasi') }}
            </h2>
            <a href="{{ route('admin_pc.unit-organisasi.index') }}" class="text-xs font-black text-slate-400 hover:text-emerald-600 transition-colors uppercase tracking-widest flex items-center gap-1">
                &larr; Batal & Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                {{-- Decorative Header Gradient --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-emerald-600"></div>

                <div class="mb-8 border-b border-gray-50 pb-6">
                    <h3 class="text-2xl font-black text-slate-800 mb-1">
                        {{ $unit->nama }}
                    </h3>
                    <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">ID Unit: #{{ $unit->id }}</p>
                </div>

                <form action="{{ route('admin_pc.unit-organisasi.update', $unit->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Sisi Kiri: Identitas --}}
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest border-b border-emerald-50 pb-2">Identitas Organisasi</p>
                            
                            <div>
                                <x-input-label value="Nama Unit Organisasi" class="font-bold text-slate-700 mb-1" />
                                <x-text-input name="nama" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold" :value="old('nama', $unit->nama)" required />
                            </div>

                            <div>
                                <x-input-label value="Tingkatan" class="font-bold text-slate-700 mb-1" />
                                <select name="level" id="level_select" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold text-sm bg-slate-50 cursor-not-allowed" disabled>
                                    <option value="pac" {{ $unit->level == 'pac' ? 'selected' : '' }}>PAC (Pimpinan Anak Cabang)</option>
                                    <option value="pr" {{ $unit->level == 'pr' ? 'selected' : '' }}>PR (Pimpinan Ranting)</option>
                                </select>
                                <p class="text-[10px] text-slate-400 mt-2 font-medium italic">* Tingkatan tidak dapat diubah setelah didaftarkan.</p>
                                <input type="hidden" name="level" value="{{ $unit->level }}">
                            </div>
                        </div>

                        {{-- Sisi Kanan: Wilayah --}}
                        <div class="space-y-6">
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-50 pb-2">Penempatan Wilayah</p>
                            
                            <div>
                                <x-input-label value="Kecamatan" class="font-bold text-slate-700 mb-1" />
                                <select name="kecamatan_id" id="kecamatan_id" class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 font-bold text-sm bg-slate-50">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach($kecamatans as $kec)
                                        <option value="{{ $kec->id }}" {{ $unit->kecamatan_id == $kec->id ? 'selected' : '' }}>{{ $kec->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if($unit->level == 'pr')
                            <div id="pr_fields" class="space-y-6 animate-fade-in">
                                <div>
                                    <x-input-label value="Pilih Desa" class="font-bold text-slate-700 mb-1" />
                                    <select name="desa_id" id="desa_id" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold text-sm bg-slate-50">
                                        <option value="{{ $unit->desa_id }}">{{ $unit->desa->nama ?? '-- Pilih Desa --' }}</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label value="Unit Induk (PAC)" class="font-bold text-slate-700 mb-1" />
                                    <select name="parent_id" class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 font-bold text-sm">
                                        @foreach($pacs as $pac)
                                            <option value="{{ $pac->id }}" {{ $unit->parent_id == $pac->id ? 'selected' : '' }}>{{ $pac->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-xs text-slate-400 font-medium italic">Terakhir diupdate: {{ $unit->updated_at->diffForHumans() }}</p>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 px-12 py-4 rounded-2xl shadow-xl transition-all hover:-translate-y-1">
                            Simpan Perubahan
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