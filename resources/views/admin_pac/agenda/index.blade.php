<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Agenda Kegiatan') }}
            </h2>
            <a href="{{ route('admin_pac.agenda.create') }}" class="flex items-center gap-2 px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Agenda
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- GRID AGENDA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($agendas as $a)
                <div class="bg-white rounded-[2.5rem] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 overflow-hidden group flex flex-col h-full">
                    
                    {{-- Header: Date & Status --}}
                    <div class="p-6 pb-0 flex justify-between items-start">
                        {{-- Date Badge --}}
                        <div class="flex flex-col items-center justify-center bg-slate-50 border border-slate-100 rounded-2xl w-14 h-14 shrink-0 text-slate-700 shadow-inner">
                            @php $date = \Carbon\Carbon::parse($a->tanggal_mulai); @endphp
                            <span class="text-[10px] font-bold uppercase tracking-wide text-slate-400">{{ $date->format('M') }}</span>
                            <span class="text-xl font-black leading-none text-emerald-600">{{ $date->format('d') }}</span>
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
                    
                    {{-- Content --}}
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-4">
                            <h4 class="font-black text-slate-800 text-lg mb-2 group-hover:text-emerald-700 transition-colors leading-tight line-clamp-2" title="{{ $a->nama }}">
                                {{ $a->nama }}
                            </h4>
                            <div class="flex items-start gap-2 text-slate-500">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <p class="text-xs font-bold uppercase tracking-wide line-clamp-2">{{ $a->lokasi }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-auto pt-5 border-t border-slate-50 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] text-slate-500">
                                    🏢
                                </div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wide">{{ $a->organisasiUnit->nama }}</span>
                            </div>
                            <a href="{{ route('admin_pac.agenda.show', $a->id) }}" class="p-2 rounded-xl bg-slate-50 text-slate-400 hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-16 text-center">
                    <div class="flex flex-col items-center gap-4 opacity-50">
                        <div class="p-6 bg-white rounded-full shadow-sm border border-slate-100">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-bold">Belum ada agenda kegiatan terdaftar.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $agendas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>