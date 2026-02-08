<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">Edit Identitas Ranting</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-orange-500"></div>

                <form action="{{ route('admin_pac.ranting.update', $ranting->id) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <x-input-label value="Nama Ranting" class="font-black text-[10px] uppercase text-slate-400 mb-2" />
                        <x-text-input name="nama" class="w-full rounded-2xl" :value="old('nama', $ranting->nama)" required />
                    </div>
                    <div>
                        <x-input-label value="Cakupan Desa" class="font-black text-[10px] uppercase text-slate-400 mb-2" />
                        <select name="desa_id" class="w-full rounded-2xl border-gray-100 font-bold text-sm bg-slate-50 focus:ring-indigo-500">
                            @foreach($desas as $desa)
                                <option value="{{ $desa->id }}" {{ $ranting->desa_id == $desa->id ? 'selected' : '' }}>{{ $desa->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-6 flex justify-end">
                        <x-primary-button class="bg-indigo-700 rounded-2xl px-10 py-4 shadow-lg shadow-indigo-100">Simpan Perubahan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>