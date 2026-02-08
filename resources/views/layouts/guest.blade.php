<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Satria Tulungagung') }}</title>
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/logo-tab.png?v=1') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo-tab.png?v=1') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/logo-tab.png?v=1') }}">
        <link rel="shortcut icon" href="{{ asset('img/logo-tab.png?v=1') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50">
        {{-- Container Utama: Menggunakan p-4 (lebih kecil dari p-6) agar tidak memakan tempat --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 p-4">
            {{ $slot }}
        </div>
    </body>
</html>