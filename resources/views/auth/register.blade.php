<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registrasi - {{ config('app.name', 'Satria Tulungagung') }}</title>

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/logo-tab.png?v=1') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo-tab.png?v=1') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/logo-tab.png?v=1') }}">
    <link rel="shortcut icon" href="{{ asset('img/logo-tab.png?v=1') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased bg-slate-50 selection:bg-emerald-500 selection:text-white">

    <div class="min-h-screen flex flex-col justify-center items-center py-10 px-4 sm:px-6">

        {{-- CARD REGISTER --}}
        <div class="w-full sm:max-w-[480px] bg-white shadow-2xl shadow-slate-200/60 overflow-hidden rounded-[2.5rem] border border-white">

            {{-- HEADER SECTION --}}
            <div class="pt-12 pb-8 px-8 text-center">
                <div class="flex justify-center mb-6">
                    <a href="/" class="transition-transform hover:scale-105 duration-300">
                        <img src="{{ asset('img/logo-view.png') }}" alt="Logo Satria" class="h-24 w-auto drop-shadow-sm object-contain">
                    </a>
                </div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase leading-none">
                    Registrasi <br><span class="text-emerald-600">Keanggotaan</span>
                </h2>
                <p class="text-xs font-bold text-slate-400 mt-3 uppercase tracking-[0.2em]">
                    Bergabung dalam Khidmah
                </p>
            </div>

            <div class="px-8 pb-10 md:px-12 md:pb-12 bg-white">

                {{-- ERROR MESSAGES --}}
                @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex gap-3 items-start">
                    <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h4 class="text-xs font-bold text-rose-700 uppercase tracking-wide">Kendala Registrasi</h4>
                        <ul class="mt-1 text-xs text-rose-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                {{-- SESSION STATUS --}}
                @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex gap-3 items-center">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-emerald-700 text-sm font-medium">{{ session('status') }}</p>
                </div>
                @endif

                {{-- GOOGLE REGISTER BUTTON --}}
                <div class="space-y-4">
                    <a href="{{ route('auth.google.register') }}"
                        class="relative flex items-center justify-center gap-3 w-full py-4 px-6 bg-white border-2 border-slate-100 hover:border-emerald-500 hover:bg-emerald-50/30 rounded-2xl transition-all duration-300 group overflow-hidden">
                        
                        {{-- Google Icon (Inline SVG for crispness) --}}
                        <svg class="w-5 h-5 relative z-10" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                        </svg>

                        <span class="text-sm font-extrabold text-slate-700 group-hover:text-emerald-800 tracking-wide relative z-10 transition-colors">
                            Daftar menggunakan Google
                        </span>
                    </a>
                </div>

                {{-- DIVIDER --}}
                <div class="relative flex py-8 items-center">
                    <div class="flex-grow border-t border-slate-100"></div>
                    <span class="flex-shrink-0 mx-4 text-[10px] text-slate-300 font-black uppercase tracking-widest">Informasi Pendaftaran</span>
                    <div class="flex-grow border-t border-slate-100"></div>
                </div>

                {{-- INFO BOX --}}
                <div class="bg-slate-50/50 rounded-2xl p-5 border border-slate-100">
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-white rounded-lg shadow-sm shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Catatan Penting</h5>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed mb-2">
                                Akun Google Anda akan digunakan sebagai identitas tunggal untuk mengakses seluruh layanan Satria.
                            </p>
                            <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                <p class="text-[10px] font-bold text-emerald-800 leading-relaxed">
                                    <span class="uppercase tracking-wider">Khusus Admin Unit:</span><br>
                                    Silakan mendaftar sebagai anggota reguler terlebih dahulu. Akses manajerial akan diaktifkan setelah verifikasi oleh Admin Pimpinan Cabang.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- LOGIN LINK --}}
                <div class="text-center pt-8">
                    <p class="text-xs text-slate-400 font-medium">
                        Sudah memiliki akun terdaftar?
                    </p>
                    <a href="{{ route('login') }}" class="inline-block mt-2 text-sm font-black text-emerald-600 hover:text-emerald-800 transition-colors uppercase tracking-wide hover:underline decoration-2 underline-offset-4">
                        Masuk ke Sistem &rarr;
                    </a>
                </div>

                {{-- FOOTER --}}
                <div class="text-center mt-12 border-t border-slate-50 pt-6">
                    <p class="text-[10px] text-slate-300 font-bold uppercase tracking-[0.2em]">
                        {{ config('app.name') }} &copy; {{ date('Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>