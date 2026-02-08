<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">

            {{-- 1. LEFT SIDE: LOGO & MENU --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('anggota.dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('img/logo-view.png') }}" alt="Logo Satria" class="h-10 w-auto">
                        <div class="font-black text-emerald-700 text-lg tracking-tighter uppercase whitespace-nowrap">
                            SATRIA
                        </div>
                    </a>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 lg:flex items-center">
                    <x-nav-link :href="route('anggota.dashboard')" :active="request()->routeIs('anggota.dashboard')">
                        {{ __('Data Diri') }}
                    </x-nav-link>

                    <span class="text-slate-300 font-light select-none">|</span>

                    <x-nav-link :href="route('anggota.pengkaderan.index')" :active="request()->routeIs('anggota.pengkaderan.*')">
                        {{ __('Pengkaderan') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- 2. RIGHT SIDE: PROFILE --}}
            <div class="hidden lg:flex sm:items-center sm:ms-6">
                <div class="flex flex-col items-end mr-3">
                    <span class="text-xs font-black text-emerald-600 uppercase">{{ Auth::user()->nama }}</span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Kader Ansor</span>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        {{-- Solid Color --}}
                        <button class="w-10 h-10 rounded-full bg-emerald-700 flex items-center justify-center text-white font-black text-sm uppercase hover:bg-emerald-800 transition-colors shadow-md">
                            {{ substr(Auth::user()->nama, 0, 1) }}
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('anggota.profile.edit')">⚙️ Edit Profil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-bold">🚪 Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- 3. HAMBURGER --}}
            <div class="-me-2 flex items-center lg:hidden">
                <button @click="open = true" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 4. MOBILE MENU --}}
    <div x-show="open" class="relative z-50 lg:hidden" aria-modal="true" style="display: none;">
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60" @click="open = false"></div>

        <div class="fixed inset-0 flex justify-end">
            <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">

                <div class="flex items-center justify-between px-6 pb-6 border-b border-gray-100">
                    <span class="text-lg font-black text-emerald-700 uppercase">Menu</span>
                    <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-gray-400 hover:text-emerald-600" @click="open = false">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 px-4 space-y-1">
                    <x-responsive-nav-link :href="route('anggota.dashboard')" :active="request()->routeIs('anggota.dashboard')" class="flex items-center gap-3">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Data Diri
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('anggota.pengkaderan.index')" :active="request()->routeIs('anggota.pengkaderan.*')" class="flex items-center gap-3">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Pengkaderan
                    </x-responsive-nav-link>

                    <div class="border-t border-gray-100 my-4"></div>

                    <x-responsive-nav-link :href="route('anggota.profile.edit')" class="flex items-center gap-3">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Edit Profil
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600 font-bold flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>