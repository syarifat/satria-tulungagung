<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Satria Tulungagung | PC GP Ansor</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,600,700,900|plus-jakarta-sans:400,600,800&display=swap" rel="stylesheet" />

    <link rel="icon" type="image/png" href="{{ asset('img/logo-tab.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Smooth Gradient Text */
        .text-gradient {
            background: linear-gradient(to right, #059669, #10b981);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="antialiased bg-slate-50 text-slate-800 relative selection:bg-emerald-500 selection:text-white">

    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute top-[-10%] right-[-5%] w-64 h-64 md:w-[40rem] md:h-[40rem] bg-emerald-400/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-72 h-72 md:w-[35rem] md:h-[35rem] bg-teal-400/10 rounded-full blur-3xl"></div>
    </div>

    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-lg border-b border-slate-200/60" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">

                <div class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('img/logo-view.png') }}" class="h-8 md:h-10 w-auto" alt="Logo Satria">
                    
                    <div class="flex flex-col">
                        <span class="font-heading font-black text-lg md:text-xl leading-none tracking-tight text-slate-900">SATRIA</span>
                        <span class="text-[0.6rem] md:text-[0.65rem] font-bold tracking-[0.2em] text-emerald-600 uppercase">Tulungagung</span>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#filosofi" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Filosofi</a>
                    <a href="#fungsi" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Fungsi</a>
                    <a href="#nilai" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Nilai</a>
                </div>

                <div class="hidden md:flex items-center gap-3">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-slate-900 text-white text-xs font-bold rounded-full hover:bg-slate-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        DASHBOARD
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-emerald-600 transition px-4">MASUK</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-full hover:bg-emerald-700 transition shadow-lg shadow-emerald-200 hover:shadow-emerald-300 transform hover:-translate-y-0.5">
                        DAFTAR
                    </a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-slate-700 hover:text-emerald-600 focus:outline-none p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 absolute w-full shadow-xl">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="#filosofi" class="block px-3 py-3 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">Filosofi</a>
                <a href="#fungsi" class="block px-3 py-3 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">Fungsi</a>
                <a href="#nilai" class="block px-3 py-3 rounded-lg text-base font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">Nilai</a>
                <div class="border-t border-slate-100 my-2 pt-2 flex flex-col gap-2">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-center px-4 py-3 bg-slate-900 text-white rounded-xl font-bold">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="w-full text-center px-4 py-3 border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center px-4 py-3 bg-emerald-600 text-white rounded-xl font-bold shadow-md">Daftar Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="relative pt-28 pb-20 lg:pt-40 lg:pb-32 px-4 overflow-hidden">
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -z-10 pointer-events-none select-none">
            <img src="{{ asset('img/logo-ansor.png') }}" class="w-[300px] md:w-[600px] opacity-[0.05] grayscale" alt="Watermark Ansor">
        </div>

        <div class="max-w-5xl mx-auto text-center relative z-10">

            <div class="flex flex-col items-center justify-center mb-8 animate-fade-in-down">
                
                <img src="{{ asset('img/logo-ansor.png') }}" class="h-16 md:h-24 w-auto drop-shadow-sm hover:scale-105 transition-transform duration-500 mb-5" alt="Logo GP Ansor">

                <h2 class="font-heading font-bold text-slate-500 text-[10px] md:text-xs tracking-[0.25em] uppercase text-center leading-relaxed">
                    Pimpinan Cabang Gerakan Pemuda Ansor<br>
                    <span class="text-emerald-700 font-black text-xs md:text-sm mt-1 block">Kabupaten Tulungagung</span>
                </h2>
            </div>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-6 animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Satria Data, Satria Gerakan
            </div>

            <h1 class="font-heading text-4xl sm:text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] mb-6 tracking-tight">
                SATRIA <span class="text-gradient">TULUNGAGUNG</span>
            </h1>

            <div class="max-w-3xl mx-auto mb-8">
                <div class="bg-white/70 backdrop-blur-sm border border-slate-200 rounded-2xl p-4 md:p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <p class="text-sm md:text-lg text-slate-700 leading-relaxed font-medium">
                        <span class="font-bold text-emerald-600">S</span>istem
                        <span class="font-bold text-emerald-600">A</span>plikasi
                        <span class="font-bold text-emerald-600">T</span>erpadu
                        <span class="font-bold text-emerald-600">R</span>egistrasi,
                        <span class="font-bold text-emerald-600">I</span>nformasi, dan
                        <span class="font-bold text-emerald-600">A</span>ktualisasi
                    </p>
                </div>
            </div>

            <p class="text-sm md:text-lg text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                <strong class="text-slate-800">TULUNGAGUNG</strong> menegaskan identitas kedaerahan, kebanggaan lokal, serta wilayah pengabdian kader GP Ansor.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 w-full px-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-slate-900 text-white rounded-xl font-bold uppercase tracking-wide hover:bg-emerald-800 transition shadow-xl hover:-translate-y-1 flex items-center justify-center gap-2">
                    <span>Gabung Sekarang</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="#filosofi" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-800 border border-slate-200 rounded-xl font-bold uppercase tracking-wide hover:border-emerald-300 hover:text-emerald-700 transition shadow-md hover:-translate-y-1">
                    Pelajari Filosofi
                </a>
            </div>
        </div>
    </header>

    <section id="filosofi" class="py-20 px-4 bg-white relative">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="font-heading text-3xl md:text-4xl font-black text-slate-900 mb-4">Filosofi <span class="text-emerald-600">Konseptual</span></h2>
                <p class="text-slate-600 max-w-2xl mx-auto text-sm md:text-base">
                    Nama SATRIA melambangkan kader GP Ansor sebagai pribadi yang menjaga nilai, penggerak perubahan, serta pelopor kebaikan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <div class="p-8 rounded-[2rem] bg-slate-50 hover:bg-emerald-50/50 border border-slate-100 hover:border-emerald-100 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900 mb-3">Tangguh</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Tangguh dalam pengabdian dan perjuangan organisasi tanpa kenal lelah.</p>
                </div>

                <div class="p-8 rounded-[2rem] bg-slate-50 hover:bg-emerald-50/50 border border-slate-100 hover:border-emerald-100 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900 mb-3">Berintegritas</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Berintegritas dalam data, informasi, dan gerakan yang dapat dipertanggungjawabkan.</p>
                </div>

                <div class="p-8 rounded-[2rem] bg-slate-50 hover:bg-emerald-50/50 border border-slate-100 hover:border-emerald-100 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900 mb-3">Siap Berkhidmah</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Siap berkhidmah untuk agama, bangsa, dan daerah sebagai penggerak kebaikan.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="fungsi" class="py-24 px-4 bg-emerald-900 text-white relative overflow-hidden rounded-t-[3rem]">
        <div class="absolute inset-0 opacity-[0.05]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <span class="text-emerald-300 font-bold tracking-widest text-xs uppercase mb-3 block">Fungsionalitas</span>
                <h2 class="font-heading text-3xl md:text-5xl font-black mb-6">Filosofi Fungsi Aplikasi</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-emerald-800/50 backdrop-blur-sm p-6 rounded-2xl border border-emerald-700 hover:border-emerald-500 transition duration-300">
                    <h4 class="font-bold text-xl mb-3 text-white">Pusat Registrasi</h4>
                    <p class="text-emerald-100/80 text-sm leading-relaxed">Pendataan anggota GP Ansor secara terstruktur, akurat, dan berkelanjutan.</p>
                </div>
                <div class="bg-emerald-800/50 backdrop-blur-sm p-6 rounded-2xl border border-emerald-700 hover:border-emerald-500 transition duration-300">
                    <h4 class="font-bold text-xl mb-3 text-white">Pemetaan Potensi</h4>
                    <p class="text-emerald-100/80 text-sm leading-relaxed">Mengidentifikasi keahlian, profesi, dan minat kader untuk mendukung program.</p>
                </div>
                <div class="bg-emerald-800/50 backdrop-blur-sm p-6 rounded-2xl border border-emerald-700 hover:border-emerald-500 transition duration-300">
                    <h4 class="font-bold text-xl mb-3 text-white">Media Informasi</h4>
                    <p class="text-emerald-100/80 text-sm leading-relaxed">Menyajikan aktivitas, gerakan, dan capaian secara aktual dan terpercaya.</p>
                </div>
                <div class="bg-emerald-800/50 backdrop-blur-sm p-6 rounded-2xl border border-emerald-700 hover:border-emerald-500 transition duration-300">
                    <h4 class="font-bold text-xl mb-3 text-white">Aktualisasi</h4>
                    <p class="text-emerald-100/80 text-sm leading-relaxed">Wadah bagi kader untuk berkontribusi, berkarya, dan terlibat aktif.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="nilai" class="py-20 px-4 bg-slate-50">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row gap-12 items-center">

                <div class="w-full md:w-1/3 text-center md:text-left">
                    <h2 class="font-heading text-3xl md:text-4xl font-black text-slate-900 mb-4">Nilai Dasar</h2>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Pondasi utama yang menjadi landasan gerak dan perilaku setiap kader dalam ekosistem SATRIA.
                    </p>
                </div>

                <div class="w-full md:w-2/3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:border-emerald-400 transition flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-slate-800 text-sm">Kedisiplinan & Ketertiban Data</span>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:border-emerald-400 transition flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-slate-800 text-sm">Soliditas & Persaudaraan</span>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:border-emerald-400 transition flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-slate-800 text-sm">Kemandirian & Profesionalitas</span>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:border-emerald-400 transition flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-slate-800 text-sm">Kearifan Lokal & Kebangsaan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-slate-200 py-8 px-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo-ansor.png') }}" class="h-10 w-auto grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition duration-300" alt="Logo Ansor Footer">
                
                <div class="text-left">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">SATRIA TULUNGAGUNG</p>
                    <p class="text-[10px] text-slate-500 font-bold mt-0.5">PC GP Ansor Kabupaten Tulungagung</p>
                </div>
            </div>
            <p class="text-xs text-slate-400 font-medium text-center md:text-right">
                &copy; {{ date('Y') }} All Rights Reserved.
            </p>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });

        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 10) {
                nav.classList.add('shadow-sm');
            } else {
                nav.classList.remove('shadow-sm');
            }
        });
    </script>
</body>

</html>