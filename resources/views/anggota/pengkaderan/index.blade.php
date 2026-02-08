<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Riwayat Pengkaderan') }}
            </h2>
            <a href="{{ route('anggota.pengkaderan.create') }}" class="flex items-center gap-2 px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            {{-- TABLE CARD --}}
            <div class="bg-white shadow-xl shadow-slate-200/40 rounded-[2.5rem] overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-8 py-5 border-b border-slate-100">Jenis Pengkaderan</th>
                                <th class="px-6 py-5 border-b border-slate-100">Tanggal</th>
                                <th class="px-6 py-5 border-b border-slate-100">Pelaksana</th>
                                <th class="px-6 py-5 border-b border-slate-100">No. Sertifikat</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($pengkaderans as $p)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center text-emerald-600 font-black shadow-sm group-hover:scale-110 transition-transform text-xs border border-emerald-100">
                                            📚
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">{{ $p->jenis_pengkaderan }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2 text-slate-600">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-xs font-bold">{{ $p->tanggal_pelaksanaan->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-xs font-bold text-slate-700">{{ $p->pelaksana }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    @if($p->nomor_sertifikat)
                                    <span class="inline-block px-3 py-1 bg-slate-100 text-slate-700 rounded-lg font-mono text-[10px] font-bold border border-slate-200">
                                        {{ $p->nomor_sertifikat }}
                                    </span>
                                    @else
                                    <span class="text-xs text-slate-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('anggota.pengkaderan.show', $p->id) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm" title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('anggota.pengkaderan.edit', $p->id) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('anggota.pengkaderan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 opacity-50">
                                        <div class="p-4 bg-slate-50 rounded-full">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <p class="text-slate-400 font-bold text-sm">Belum ada riwayat pengkaderan</p>
                                        <a href="{{ route('anggota.pengkaderan.create') }}" class="mt-2 text-emerald-600 hover:text-emerald-700 font-bold text-sm underline">Tambah data pertama</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($pengkaderans->hasPages())
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $pengkaderans->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>