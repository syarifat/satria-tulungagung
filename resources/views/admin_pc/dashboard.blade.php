<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-2 h-6 bg-emerald-600 rounded-full"></div>
            <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">
                {{ __('Dashboard Utama') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-900 p-10 md:p-16 rounded-[3.5rem] shadow-2xl text-white border-b-8 border-emerald-800/50">
                <div class="relative z-10">
                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-4 inline-block border border-white/30">
                        Pimpinan Cabang
                    </span>
                    <h3 class="text-3xl md:text-5xl font-black mb-3 tracking-tighter">
                        Selamat Datang, <br>Sahabat <span class="text-yellow-300">{{ Auth::user()->nama }}</span>!
                    </h3>
                    <div class="flex items-center gap-2 mt-6">
                        <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center animate-bounce shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-emerald-50 font-bold italic text-sm">
                            Ada <span class="underline decoration-yellow-400 decoration-2 underline-offset-4">{{ $stats['surat_pending'] }} surat</span> yang menunggu keputusan Anda hari ini.
                        </p>
                    </div>
                </div>
                
                <div class="absolute right-[-40px] bottom-[-60px] opacity-10 text-[18rem] font-black rotate-12 select-none pointer-events-none tracking-tighter">
                    ANSOR
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $cards = [
                        ['label' => 'Total Kader', 'val' => number_format($stats['total_anggota']), 'sub' => 'Se-Tulungagung', 'color' => 'emerald'],
                        ['label' => 'Unit Aktif', 'val' => $stats['total_pac'] + $stats['total_pr'], 'sub' => $stats['total_pac'].' PAC | '.$stats['total_pr'].' PR', 'color' => 'indigo'],
                        ['label' => 'Data Master', 'val' => $stats['total_jabatan'] + $stats['total_index'], 'sub' => 'Jabatan & Index', 'color' => 'orange'],
                        ['label' => 'Surat Pending', 'val' => $stats['surat_pending'], 'sub' => 'Perlu Approval', 'color' => 'rose'],
                    ];
                @endphp

                @foreach($cards as $card)
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 hover:-translate-y-2 transition-transform duration-300 group">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 group-hover:text-{{ $card['color'] }}-500 transition-colors">{{ $card['label'] }}</p>
                    <p class="text-5xl font-black text-slate-800 tracking-tighter">{{ $card['val'] }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $card['sub'] }}</p>
                        <div class="w-8 h-8 rounded-xl bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 flex items-center justify-center font-bold text-xs">
                            &rarr;
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 bg-white p-10 rounded-[3rem] shadow-2xl border border-gray-100">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                        <span class="flex h-3 w-3 relative">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
                        </span>
                        Agenda Pending
                    </h4>
                    <div class="space-y-6">
                        @if($stats['agenda_pending'] > 0)
                            <div class="p-6 bg-orange-50 rounded-[2rem] border border-orange-100">
                                <p class="text-sm text-orange-800 font-bold leading-relaxed">
                                    {{ $stats['agenda_pending'] }} Agenda kegiatan wilayah menunggu validasi lokasi.
                                </p>
                            </div>
                            <a href="{{ route('admin_pc.agenda.index') }}" class="block w-full py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase text-center tracking-widest hover:bg-emerald-700 transition-all shadow-lg">Tinjau Agenda</a>
                        @else
                            <div class="text-center py-10">
                                <p class="text-3xl mb-2 text-slate-200">✅</p>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Semua agenda bersih</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-2xl border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-[0.3em]">Registrasi Terbaru</h4>
                        <a href="{{ route('admin_pc.anggota.index') }}" class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-100 transition-all">Semua Data</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($latest_members as $member)
                        <div class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-colors border border-transparent hover:border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-700 font-black shadow-inner">
                                    {{ substr($member->nama, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-sm tracking-tight">{{ $member->nama }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $member->organisasiUnit->nama }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $member->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>