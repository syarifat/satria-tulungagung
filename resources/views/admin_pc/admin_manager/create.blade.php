<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Promote Admin Baru') }}
            </h2>
            <a href="{{ route('admin_pc.admin-manager.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-200 transition-all">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- SEARCH CARD --}}
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8">
                <h3 class="text-lg font-black text-slate-800 mb-4">Cari Anggota</h3>
                <form action="{{ route('admin_pc.admin-manager.create') }}" method="GET" class="flex gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="flex-1 px-6 py-4 bg-slate-50 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder:text-slate-400"
                        placeholder="Masukkan Nama atau NIK anggota...">
                    <button type="submit" class="px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-bold text-sm shadow-lg hover:shadow-xl transition-all">
                        Cari
                    </button>
                </form>
                <div class="mt-4 text-xs text-slate-400 font-medium">
                    * Hanya menampilkan anggota biasa (bukan admin).
                </div>
            </div>

            {{-- RESULTS CARD --}}
            @if(request('search') || $candidates->count() > 0)
            <div class="bg-white shadow-xl shadow-slate-200/40 rounded-[2.5rem] overflow-hidden border border-slate-100">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50">
                    <h4 class="text-sm font-black text-slate-700 uppercase tracking-widest">Hasil Pencarian</h4>
                </div>
                <ul class="divide-y divide-slate-50">
                    @forelse($candidates as $candidate)
                    <li class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-lg">
                                {{ substr($candidate->nama, 0, 1) }}
                            </div>
                            <div>
                                <h5 class="text-sm font-black text-slate-800">{{ $candidate->nama }}</h5>
                                <div class="text-xs text-slate-500 font-medium mt-0.5">NIK: {{ $candidate->nik }}</div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold uppercase tracking-wider">
                                        {{ $candidate->organisasiUnit->nama }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 uppercase font-bold">{{ $candidate->organisasiUnit->level }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            @if($candidate->organisasiUnit->level == 'pc')
                            <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-xs font-bold cursor-not-allowed">
                                Unit PC (Admin Terpusat)
                            </span>
                            @else
                            <form action="{{ route('admin_pc.admin-manager.store') }}" method="POST" onsubmit="return confirm('Promosikan {{ $candidate->nama }} menjadi Admin {{ $candidate->organisasiUnit->nama }}?');">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $candidate->id }}">
                                <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg hover:shadow-xl transition-all shadow-emerald-100 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Jadikan Admin
                                </button>
                            </form>
                            @endif
                        </div>
                    </li>
                    @empty
                    <li class="p-8 text-center text-slate-400 font-bold">
                        Tidak ditemukan anggota yang cocok.
                    </li>
                    @endforelse
                </ul>
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $candidates->withQueryString()->links() }}
                </div>
            </div>
            @else
            <div class="text-center py-12 text-slate-400 font-bold">
                Silakan cari nama anggota terlebih dahulu untuk menambah admin baru.
            </div>
            @endif
        </div>
    </div>
</x-app-layout>