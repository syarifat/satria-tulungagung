<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 uppercase tracking-tight">Database Kader Desa</h2>
            <a href="{{ route('admin_pr.anggota.create') }}" class="px-6 py-2.5 bg-teal-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-teal-100">+ Tambah Anggota</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- Tabel Data Kader --}}
            <div class="bg-white shadow-xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                            <th class="px-8 py-5 border-b border-slate-100">Nama Lengkap</th>
                            <th class="px-6 py-5 border-b border-slate-100">Jabatan Ranting</th>
                            <th class="px-6 py-5 border-b border-slate-100 text-center">Status User</th>
                            <th class="px-8 py-5 border-b border-slate-100 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($anggotas as $agt)
                        <tr class="hover:bg-teal-50/30 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="font-black text-slate-800 text-sm group-hover:text-teal-600 transition-colors">{{ $agt->nama }}</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">NIK: {{ $agt->nik }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 bg-teal-50 text-teal-700 text-[9px] font-black rounded-lg border border-teal-100 uppercase italic">
                                    {{ $agt->jabatan->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-lg uppercase">Aktif</span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <a href="{{ route('admin_pr.anggota.edit', $agt->id) }}" class="text-[10px] font-black text-slate-400 hover:text-teal-600 uppercase tracking-widest transition-colors">Edit Data &rarr;</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-slate-400 italic font-bold">Belum ada kader terdaftar di Ranting ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $anggotas->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>