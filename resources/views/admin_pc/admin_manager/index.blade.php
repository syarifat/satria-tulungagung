<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Manajemen Admin Unit') }}
            </h2>
            <span class="px-4 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider">
                Konfigurasi Akses
            </span>
        </div>
    </x-slot>

    <div class="py-8 md:py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- 1. HEADER & ACTIONS --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">Daftar Admin</h3>
                    <p class="text-slate-500 font-medium mt-1">Kelola pengguna yang memiliki hak akses admin di unit (PAC/Ranting).</p>
                </div>
                <a href="{{ route('admin_pc.admin-manager.create') }}" class="flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Promote Admin Baru
                </a>
            </div>

            {{-- 2. FILTER CARD --}}
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-1">
                <form action="{{ route('admin_pc.admin-manager.index') }}" method="GET" class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">

                        {{-- Search --}}
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Cari Nama</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full px-4 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder:text-slate-400"
                                placeholder="Nama admin...">
                        </div>

                        {{-- Filter PAC --}}
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Filter PAC</label>
                            <select name="pac_id" onchange="this.form.submit()"
                                class="w-full px-4 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer appearance-none transition-all">
                                <option value="">Semua Wilayah</option>
                                @foreach($allPacs as $pac)
                                <option value="{{ $pac->id }}" {{ request('pac_id') == $pac->id ? 'selected' : '' }}>{{ $pac->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter PR --}}
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Filter Ranting</label>
                            <select name="pr_id" class="w-full px-4 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer appearance-none transition-all" {{ empty($prs) ? 'disabled' : '' }}>
                                <option value="">Semua Ranting</option>
                                @if(!empty($prs))
                                @foreach($prs as $pr)
                                <option value="{{ $pr->id }}" {{ request('pr_id') == $pr->id ? 'selected' : '' }}>{{ $pr->nama }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="md:col-span-3">
                            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-sm font-bold shadow-md hover:shadow-lg transition-all uppercase tracking-wide">
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 3. TABLE --}}
            <div class="bg-white shadow-xl shadow-slate-200/40 rounded-[2.5rem] overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <th class="px-8 py-5 border-b border-slate-100">Nama Admin</th>
                                <th class="px-6 py-5 border-b border-slate-100">Unit Organisasi</th>
                                <th class="px-6 py-5 border-b border-slate-100 text-center">Role / Level</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($admins as $admin)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="font-black text-slate-800 text-sm mb-1">{{ $admin->nama }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium">{{ $admin->email }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-xs font-bold text-slate-700">{{ $admin->organisasiUnit->nama }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium uppercase">{{ $admin->organisasiUnit->level }}</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-block px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border 
                                        {{ $admin->role == 'admin_pac' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100' }}">
                                        {{ $admin->role == 'admin_pac' ? 'Admin Kecamatan' : 'Admin Ranting' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <form action="{{ route('admin_pc.admin-manager.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mencabut akses admin dari user ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all text-[10px] font-bold uppercase tracking-wide border border-rose-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Copot Admin
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold">
                                    Belum ada data admin unit.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>