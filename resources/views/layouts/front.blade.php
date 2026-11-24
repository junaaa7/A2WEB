<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark-frontend">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A2WEB | Jasa Pembuatan Website &amp; Skripsi IT</title>
    <!-- Favicon Logo A2WEB -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v={{ @filemtime(public_path('favicon-32x32.png')) ?: 2 }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v={{ @filemtime(public_path('favicon-16x16.png')) ?: 2 }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ @filemtime(public_path('favicon.ico')) ?: 2 }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v={{ @filemtime(public_path('apple-touch-icon.png')) ?: 2 }}">
    <!-- Google Fonts: Space Grotesk, Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <!-- Memuat Tailwind CSS melalui Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-tech-body antialiased bg-[#060919] text-[#F8FAFC] overflow-x-hidden selection:bg-cyan-400 selection:text-[#060919]">

    <!-- Reading / Scroll Progress Bar (GPU-accelerated scaleX) -->
    <div id="scroll-progress-bar"
         aria-hidden="true"
         class="fixed top-0 left-0 right-0 h-[2px] sm:h-[3px] z-[60] pointer-events-none origin-left bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 scale-x-0 will-change-transform shadow-[0_0_8px_rgba(34,211,238,0.65)]"></div>

    <!-- Navbar Dark Glass + Logo Asli A2 WEB -->
    <nav id="main-navbar"
         x-data="{ mobileMenuOpen: false }"
         @keydown.escape.window="mobileMenuOpen = false"
         @click.outside="mobileMenuOpen = false"
         class="fixed top-0 inset-x-0 bg-[#060919]/80 backdrop-blur-xl border-b border-cyan-400/15 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center gap-2">
                <!-- Brand Logo + Wordmark -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="#hero" class="inline-flex items-center gap-2.5 group">
                        <img src="{{ asset('apple-touch-icon.png') }}?v={{ @filemtime(public_path('apple-touch-icon.png')) ?: 2 }}"
                             alt="Logo A2 WEB"
                             class="w-9 h-9 rounded-full object-cover ring-1 ring-cyan-400/50 shadow-[0_0_12px_rgba(34,211,238,0.25)] group-hover:ring-cyan-300 transition-all">
                        <span class="font-tech-display text-xl sm:text-2xl font-bold tracking-tight text-[#F8FAFC]">
                            A2<span class="text-cyan-400">Web</span>
                        </span>
                    </a>
                </div>

                <!-- Navigasi Desktop -->
                <div class="hidden md:flex items-center space-x-7 lg:space-x-8">
                    <a href="#hero" data-scrollspy-link class="nav-link relative text-sm font-medium text-[#CBD5E1] hover:text-[#22D3EE] py-1 transition-colors after:absolute after:left-0 after:bottom-0 after:h-[1.5px] after:w-0 after:bg-cyan-400 hover:after:w-full after:transition-all after:duration-200">Beranda</a>
                    <a href="#portfolio" data-scrollspy-link class="nav-link relative text-sm font-medium text-[#CBD5E1] hover:text-[#22D3EE] py-1 transition-colors after:absolute after:left-0 after:bottom-0 after:h-[1.5px] after:w-0 after:bg-cyan-400 hover:after:w-full after:transition-all after:duration-200">Portofolio</a>
                    <a href="#layanan" data-scrollspy-link class="nav-link relative text-sm font-medium text-[#CBD5E1] hover:text-[#22D3EE] py-1 transition-colors after:absolute after:left-0 after:bottom-0 after:h-[1.5px] after:w-0 after:bg-cyan-400 hover:after:w-full after:transition-all after:duration-200">Layanan</a>
                    <a href="#faq" data-scrollspy-link class="nav-link relative text-sm font-medium text-[#CBD5E1] hover:text-[#22D3EE] py-1 transition-colors after:absolute after:left-0 after:bottom-0 after:h-[1.5px] after:w-0 after:bg-cyan-400 hover:after:w-full after:transition-all after:duration-200">FAQ</a>
                </div>

                <!-- Aksi Kanan -->
                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-tech-mono text-xs font-medium text-cyan-300 border border-cyan-400/25 bg-[#0E1530]/80 hover:border-cyan-400/60 hover:text-white transition">
                            <span>Dashboard</span>
                        </a>
                    @endauth

                    <a href="#kontak" class="group relative inline-flex items-center p-[1px] rounded-xl bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 shadow-[0_0_18px_-6px_rgba(34,211,238,0.45)] hover:shadow-[0_0_22px_-4px_rgba(34,211,238,0.65)] transition-all duration-200">
                        <span class="inline-flex items-center gap-1.5 px-3.5 sm:px-4 md:px-5 py-2 min-h-[38px] rounded-[11px] bg-[#0B1126] group-hover:bg-[#0E1530]/60 text-white font-semibold text-xs sm:text-sm whitespace-nowrap transition-colors">
                            <span>Pesan Sekarang</span>
                            <svg class="hidden sm:inline w-3.5 h-3.5 text-cyan-300 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </span>
                    </a>

                    <!-- Tombol Hamburger Mobile -->
                    <button type="button"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            :aria-expanded="mobileMenuOpen.toString()"
                            aria-label="Toggle Menu Navigasi"
                            class="md:hidden inline-flex items-center justify-center p-2 min-w-[44px] min-h-[44px] rounded-xl text-slate-200 border border-cyan-400/20 bg-[#0E1530]/80 hover:border-cyan-400/50 hover:text-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 transition">
                        <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Dropdown Mobile (Dark Theme #0A1026) -->
        <div x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-[#0A1026]/95 backdrop-blur-xl border-t border-cyan-400/15 shadow-2xl">
            <div class="px-4 py-3 space-y-1">
                <a href="#hero" data-scrollspy-mobile @click="mobileMenuOpen = false" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 min-h-[44px] rounded-xl text-base font-medium text-slate-200 hover:text-cyan-300 hover:bg-[#0E1530] transition">
                    <span>Beranda</span>
                    <span class="font-tech-mono text-xs text-cyan-400/70">00</span>
                </a>
                <a href="#portfolio" data-scrollspy-mobile @click="mobileMenuOpen = false" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 min-h-[44px] rounded-xl text-base font-medium text-slate-200 hover:text-cyan-300 hover:bg-[#0E1530] transition">
                    <span>Portofolio</span>
                    <span class="font-tech-mono text-xs text-cyan-400/70">01</span>
                </a>
                <a href="#layanan" data-scrollspy-mobile @click="mobileMenuOpen = false" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 min-h-[44px] rounded-xl text-base font-medium text-slate-200 hover:text-cyan-300 hover:bg-[#0E1530] transition">
                    <span>Layanan</span>
                    <span class="font-tech-mono text-xs text-cyan-400/70">03</span>
                </a>
                <a href="#faq" data-scrollspy-mobile @click="mobileMenuOpen = false" class="mobile-nav-link flex items-center justify-between px-3.5 py-2.5 min-h-[44px] rounded-xl text-base font-medium text-slate-200 hover:text-cyan-300 hover:bg-[#0E1530] transition">
                    <span>FAQ</span>
                    <span class="font-tech-mono text-xs text-cyan-400/70">04</span>
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" @click="mobileMenuOpen = false" class="flex items-center justify-between px-3.5 py-2.5 min-h-[44px] rounded-xl text-base font-medium text-cyan-300 bg-[#0E1530] border border-cyan-400/20 transition">
                        <span>Dashboard Admin</span>
                        <span class="font-tech-mono text-xs">&rarr;</span>
                    </a>
                @endauth
                <div class="pt-2 border-t border-slate-800">
                    <a href="#kontak" @click="mobileMenuOpen = false" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 min-h-[44px] rounded-xl bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 text-white font-semibold shadow-[0_0_20px_-6px_rgba(34,211,238,0.5)] transition">
                        <span>Pesan Sekarang</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Dark Precision Tech (#040712) -->
    <footer class="bg-[#040712] text-slate-300 relative overflow-hidden">
        <!-- Garis Atas Gradasi Tipis 1px -->
        <div class="h-px w-full bg-gradient-to-r from-transparent via-cyan-400/50 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                <!-- Brand + Deskripsi -->
                <div data-reveal="up" data-reveal-delay="0" class="md:col-span-5 space-y-4">
                    <a href="#hero" class="inline-flex items-center gap-3">
                        <img src="{{ asset('apple-touch-icon.png') }}?v={{ @filemtime(public_path('apple-touch-icon.png')) ?: 2 }}"
                             alt="Logo A2 WEB"
                             class="w-9 h-9 rounded-full object-cover ring-1 ring-cyan-400/50 shadow-[0_0_14px_rgba(34,211,238,0.25)]">
                        <span class="font-tech-display text-2xl font-bold tracking-tight text-[#F8FAFC]">
                            A2<span class="text-cyan-400">Web</span>
                        </span>
                    </a>
                    <p class="text-sm text-[#94A3B8] leading-relaxed max-w-sm">
                        Studio teknologi web untuk pengembangan aplikasi bisnis UMKM, sistem informasi custom, dan pendampingan sistem skripsi IT dengan arsitektur kode yang presisi.
                    </p>
                </div>

                <!-- Navigasi Cepat -->
                <div data-reveal="up" data-reveal-delay="80" class="md:col-span-3">
                    <h3 class="font-tech-mono text-xs uppercase tracking-widest text-cyan-400 mb-4">Navigasi Cepat</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#hero" class="text-slate-400 hover:text-cyan-300 transition-colors">Beranda</a></li>
                        <li><a href="#portfolio" class="text-slate-400 hover:text-cyan-300 transition-colors">Project Showcase</a></li>
                        <li><a href="#proses" class="text-slate-400 hover:text-cyan-300 transition-colors">Alur Pengerjaan</a></li>
                        <li><a href="#layanan" class="text-slate-400 hover:text-cyan-300 transition-colors">Layanan &amp; Harga</a></li>
                        <li><a href="#faq" class="text-slate-400 hover:text-cyan-300 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Konsultasi -->
                <div data-reveal="up" data-reveal-delay="160" class="md:col-span-4 space-y-4">
                    <h3 class="font-tech-mono text-xs uppercase tracking-widest text-purple-400 mb-2">Mulai Proyek</h3>
                    <p class="text-sm text-[#94A3B8] leading-relaxed">
                        Siap membangun aplikasi web atau menyelesaikan sistem skripsi Anda? Konsultasikan langsung via form order WhatsApp.
                    </p>
                    <a href="#kontak" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 min-h-[44px] rounded-xl bg-[#0E1530] border border-cyan-400/30 hover:border-cyan-400 text-cyan-200 hover:text-white text-sm font-semibold transition-all">
                        <span>Konsultasi via WhatsApp</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            <div data-reveal="fade" data-reveal-delay="120" class="mt-10 pt-6 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} A2Web &bull; Porto Juns Web. All rights reserved.</p>
                <p class="font-tech-mono text-slate-500">Precision Web Studio &bull; Laravel 13</p>
            </div>
        </div>
    </footer>

    <!-- Floating Back to Top Button -->
    <button id="back-to-top"
            type="button"
            aria-label="Kembali ke atas"
            title="Kembali ke atas"
            class="fixed bottom-5 right-5 z-40 w-11 h-11 rounded-xl bg-[#0B1126]/90 backdrop-blur-md border border-cyan-400/35 hover:border-cyan-400 text-cyan-300 hover:text-white shadow-[0_8px_24px_-6px_rgba(34,211,238,0.3)] hover:shadow-[0_0_24px_-4px_rgba(34,211,238,0.55)] flex items-center justify-center transition-all duration-300 opacity-0 scale-90 pointer-events-none focus:outline-none focus:ring-2 focus:ring-cyan-400/50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 15l7-7 7 7" />
        </svg>
    </button>

</body>
</html>
