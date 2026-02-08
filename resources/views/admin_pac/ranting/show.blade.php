<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">Detail Ranting {{ $ranting->nama }}</h2>
            <a href="{{ route('admin_pac.ranting.index') }}" class="text-xs font-black text-slate-400 hover:text-indigo-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white p-10 shadow-2xl rounded-[3rem] border border-gray-100 flex flex-col md:flex-row gap-8 items-center">
                <div class="w-24 h-24 bg-indigo-100 rounded-[2rem] flex items-center justify-center text-indigo-700 text-3xl font-black">
                    {{ substr($ranting->nama, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight">{{ $ranting->nama }}</h3>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-1">Wilayah Desa: {{ $ranting->desa->nama ?? '-' }}</p>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                <div class="px-8 py-6 bg-slate-50 border-b border-slate-100">
                    <h4 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em]">Daftar Pengurus Ranting</h4>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-50">
                        @foreach($ranting->anggotas as $agt)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-4 font-bold text-slate-700 text-sm">{{ $agt->nama }}</td>
                            <td class="px-8 py-4 text-right">
                                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">{{ $agt->jabatan->nama }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>