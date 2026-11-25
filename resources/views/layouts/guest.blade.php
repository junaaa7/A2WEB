<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark-theme">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>A2WEB | Autentikasi</title>

        <!-- Favicon Logo A2WEB -->
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v={{ @filemtime(public_path('favicon-32x32.png')) ?: 2 }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v={{ @filemtime(public_path('favicon-16x16.png')) ?: 2 }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ @filemtime(public_path('favicon.ico')) ?: 2 }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v={{ @filemtime(public_path('apple-touch-icon.png')) ?: 2 }}">

        <!-- Google Fonts: Space Grotesk, Plus Jakarta Sans & JetBrains Mono -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-tech-body antialiased bg-[#060919] text-[#F8FAFC] overflow-x-hidden selection:bg-cyan-400 selection:text-[#060919]">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-6 bg-[#060919]">
            <div class="mb-6">
                <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-3 group focus:outline-none">
                    <img src="{{ asset('apple-touch-icon.png') }}?v={{ @filemtime(public_path('apple-touch-icon.png')) ?: 2 }}"
                         alt="Logo A2 WEB"
                         class="w-14 h-14 rounded-full object-cover ring-1 ring-cyan-400/50 shadow-[0_0_18px_rgba(34,211,238,0.3)] group-hover:ring-cyan-300 transition-all">
                    <span class="font-tech-display text-2xl font-bold tracking-tight text-[#F8FAFC]">
                        A2<span class="text-cyan-400">Web</span>
                        <span class="text-slate-300 font-semibold">Admin</span>
                    </span>
                </a>
            </div>

            <div class="w-full max-w-md px-5 py-6 sm:px-8 sm:py-7 bg-[#0E1530] border border-cyan-400/20 shadow-2xl overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
