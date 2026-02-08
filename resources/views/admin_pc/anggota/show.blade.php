<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Profil Anggota</h2>
            <a href="{{ route('admin_pc.anggota.index') }}" class="text-xs font-black text-slate-400 hover:text-emerald-600 uppercase tracking-widest">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- HEADER PROFILE CARD --}}
            <div class="bg-white shadow-2xl rounded-[3rem] border border-gray-100 overflow-hidden relative">
                <div class="h-32 bg-gradient-to-r from-emerald-600 to-indigo-700"></div>
                <div class="px-8 pb-8">
                    <div class="relative flex justify-between items-end -mt-16 mb-6">
                        <div class="p-2 bg-white rounded-[2rem] shadow-xl">
                            @if($anggota->url_foto)
                                <img src="{{ asset('storage/' . $anggota->url_foto) }}" class="w-32 h-32 rounded-[1.8rem] object-cover border-4 border-white">
                            @else
                                <div class="w-32 h-32 rounded-[1.8rem] bg-emerald-100 flex items-center justify-center text-4xl font-black text-emerald-700 border-4 border-white">
                                    {{ substr($anggota->nama, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex gap-3 mb-4">
                            <a href="{{ route('admin_pc.anggota.edit', ['anggota' => $anggota->id]) }}" class="px-6 py-2.5 bg-orange-500 text-white rounded-xl text-xs font-bold shadow-lg hover:bg-orange-600 transition">Edit Profil</a>
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-black text-slate-800">{{ $anggota->nama }}</h1>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">{{ $anggota->jabatan->nama ?? '-' }} - {{ $anggota->organisasiUnit->nama ?? '-' }}</p>
                </div>
            </div>

            {{-- GRID INFORMASI LENGKAP --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- KOLOM 1: IDENTITAS PRIBADI --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50 h-fit">
                    <h4 class="text-xs font-black text-emerald-600 uppercase tracking-[0.2em] border-b pb-4 mb-6">Identitas Pribadi</h4>
                    <div class="space-y-5">
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">NIK (KTP)</p>
                            <p class="font-bold text-slate-800">{{ $anggota->nik }}</p>
                        </div>
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">NIA Ansor</p>
                            <p class="font-bold text-slate-800">{{ $anggota->nia_ansor ?? '-' }}</p>
                        </div>
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Tempat, Tanggal Lahir</p>
                            <p class="font-bold text-slate-800">
                                {{ $anggota->tempat_lahir }}, {{ $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('d F Y') : '-' }}
                            </p>
                        </div>
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Jenis Kelamin</p>
                            <p class="font-bold text-slate-800">
                                {{ $anggota->kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        </div>
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Status Perkawinan</p>
                            <p class="font-bold text-slate-800 capitalize">{{ str_replace('_', ' ', $anggota->status_kawin) }}</p>
                        </div>
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Email Akun</p>
                            <p class="font-bold text-slate-800 break-words">{{ $anggota->user->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- KOLOM 2: KONTAK & ALAMAT --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50 h-fit">
                    <h4 class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em] border-b pb-4 mb-6">Kontak & Domisili</h4>
                    <div class="space-y-5">
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Nomor Telepon / WA</p>
                            <p class="font-bold text-slate-800">{{ $anggota->notelp ?? '-' }}</p>
                        </div>
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Alamat Lengkap</p>
                            <p class="font-medium text-slate-700 leading-relaxed">{{ $anggota->alamat ?? '-' }}</p>
                        </div>
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Desa / Kelurahan</p>
                            <p class="font-bold text-slate-800">{{ $anggota->desa->nama ?? '-' }}</p>
                        </div>
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Kecamatan</p>
                            <p class="font-bold text-slate-800">{{ $anggota->kecamatan->nama ?? '-' }}</p>
                        </div>
                        <div class="pt-4 border-t border-dashed border-gray-200">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Pendidikan Terakhir</p>
                            <p class="font-bold text-slate-800">{{ $anggota->last_education ?? '-' }}</p>
                        </div>
                        <div class="group">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Pekerjaan</p>
                            <p class="font-bold text-slate-800">{{ $anggota->job_title ?? '-' }}</p>
                            <p class="text-xs text-slate-500">{{ $anggota->job_address ?? '' }}</p>
                        </div>
                    </div>
                </div>

                {{-- KOLOM 3: RIWAYAT PENGKADERAN (Looping) --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50 h-fit">
                    <h4 class="text-xs font-black text-orange-500 uppercase tracking-[0.2em] border-b pb-4 mb-6">Riwayat Pengkaderan</h4>
                    
                    @if($anggota->riwayatPengkaderans->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-xs text-slate-400 italic">Belum ada data pengkaderan.</p>
                        </div>
                    @else
                        <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                            @foreach($anggota->riwayatPengkaderans as $riwayat)
                                <div class="ml-6 relative">
                                    <div class="absolute -left-[1.95rem] top-1 w-4 h-4 bg-orange-500 rounded-full border-4 border-white shadow-sm"></div>
                                    <h5 class="font-black text-slate-800">{{ $riwayat->jenis_pengkaderan }}</h5>
                                    <p class="text-xs font-bold text-slate-500">{{ $riwayat->tanggal_pelaksanaan ? $riwayat->tanggal_pelaksanaan->format('Y') : '-' }}</p>
                                    <div class="mt-2 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                        <p class="text-[10px] text-slate-400 font-bold uppercase">Pelaksana</p>
                                        <p class="text-xs font-semibold text-slate-700">{{ $riwayat->pelaksana }}</p>
                                        
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-2">No. Sertifikat</p>
                                        <p class="text-xs font-mono text-slate-600 bg-white px-1 rounded inline-block border">{{ $riwayat->nomor_sertifikat ?? '-' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>