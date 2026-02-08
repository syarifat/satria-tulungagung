<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Manajemen Kegiatan') }}
            </h2>
            <span class="px-4 py-1.5 rounded-full bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                Agenda & Acara
            </span>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- 1. HEADER STATS --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">Monitoring Agenda</h3>
                    <p class="text-slate-500 font-medium mt-1">Jadwal kegiatan dan permohonan acara dari unit.</p>
                </div>
                
                {{-- Quick Stats --}}
                <div class="flex gap-3">
                    <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3">
                        <div class="p-2 bg-orange-50 text-orange-500 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Pending</p>
                            <p class="text-lg font-black text-slate-800">{{ $agendas->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                    <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3">
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Agenda</p>
                            <p class="text-lg font-black text-slate-800">{{ $agendas->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. FILTER & SEARCH --}}
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-1">
                <form action="{{ route('admin_pc.agenda.index') }}" method="GET" class="p-4 md:p-6 flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full pl-6 pr-4 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder:text-slate-400" 
                            placeholder="Cari Nama Kegiatan...">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="status" onchange="this.form.submit()" 
                            class="w-full pl-4 pr-10 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer transition-all">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-slate-800 transition-all shadow-lg">
                        Cari
                    </button>
                </form>
            </div>

            {{-- 3. AGENDA GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($agendas as $a)
                <div class="bg-white rounded-[2.5rem] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 overflow-hidden group flex flex-col h-full">
                    
                    {{-- Card Header --}}
                    <div class="p-6 pb-0 flex justify-between items-start">
                        {{-- Date Badge --}}
                        <div class="flex flex-col items-center justify-center bg-slate-50 border border-slate-100 rounded-2xl w-14 h-14 shrink-0 text-slate-700">
                            @php 
                                $date = \Carbon\Carbon::parse($a->tanggal_mulai); 
                            @endphp
                            <span class="text-xs font-bold uppercase">{{ $date->format('M') }}</span>
                            <span class="text-xl font-black leading-none">{{ $date->format('d') }}</span>
                        </div>

                        {{-- Status Badge --}}
                        @php
                            $statusClass = match($a->status) {
                                'pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                'disetujui' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'ditolak' => 'bg-rose-50 text-rose-600 border-rose-100',
                                default => 'bg-slate-50 text-slate-600 border-slate-100',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $statusClass }}">
                            {{ $a->status }}
                        </span>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-4">
                            <h3 class="text-lg font-black text-slate-800 leading-tight mb-2 group-hover:text-indigo-700 transition-colors line-clamp-2" title="{{ $a->nama }}">
                                {{ $a->nama }}
                            </h3>
                            <div class="flex items-start gap-2 text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-0.5 shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-xs font-bold line-clamp-2">{{ $a->lokasi }}</p>
                            </div>
                        </div>

                        <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                            {{-- Unit Name --}}
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-indigo-50 flex items-center justify-center text-[10px] font-black text-indigo-600">
                                    {{ substr($a->organisasiUnit->nama, 0, 1) }}
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide truncate max-w-[100px]">
                                    {{ $a->organisasiUnit->nama }}
                                </span>
                            </div>

                            {{-- Action --}}
                            <a href="{{ route('admin_pc.agenda.show', $a->id) }}" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-800 hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-slate-500 font-bold">Belum ada agenda kegiatan.</p>
                </div>
                @endforelse
            </div>

            {{-- 4. PAGINATION --}}
            <div class="mt-8">
                {{ $agendas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>