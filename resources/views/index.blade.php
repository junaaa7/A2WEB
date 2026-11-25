@extends('layouts.front')

@section('content')

@php
    $portfolioCategories = $projects->pluck('category')->filter()->unique()->values();
@endphp

<!-- 1. HERO SECTION (SOLID DARK COSMIC NAVY + A2 WEB WATERMARK) -->
<section id="hero" class="relative overflow-hidden bg-[#060919] scroll-mt-20 pt-32 pb-16 sm:pt-36 sm:pb-20 lg:pt-40 lg:pb-24">
    <!-- Centerpiece Background Watermark Logo A2 WEB -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none z-0 overflow-hidden" aria-hidden="true">
        <div id="hero-logo-parallax" class="flex items-center justify-center pointer-events-none">
            <img src="{{ asset('images/logo-a2web-hero.jpg') }}?v={{ @filemtime(public_path('images/logo-a2web-hero.jpg')) ?: 1 }}"
                 alt=""
                 class="shrink-0 -translate-y-6 sm:-translate-y-8 w-[320px] h-[320px] sm:w-[440px] sm:h-[440px] md:w-[540px] md:h-[540px] lg:w-[640px] lg:h-[640px] max-w-none object-cover rounded-full mix-blend-screen opacity-[0.14] sm:opacity-[0.18] [mask-image:radial-gradient(circle,black_45%,transparent_72%)] [-webkit-mask-image:radial-gradient(circle,black_45%,transparent_72%)]">
        </div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center flex flex-col items-center justify-center">
            <h1 data-reveal="up" data-reveal-delay="0" class="hero-reveal font-tech-display text-3xl sm:text-5xl lg:text-[3.4rem] font-bold tracking-tight text-[#F8FAFC] leading-tight mb-6 break-words drop-shadow-[0_2px_16px_rgba(6,9,25,0.9)]">
                Solusi Cerdas Pembuatan Website Profesional
                &amp; Pendampingan Sistem Skripsi
            </h1>

            <p data-reveal="up" data-reveal-delay="65" class="hero-reveal text-base sm:text-lg text-[#94A3B8] leading-relaxed max-w-2xl mx-auto mb-8 drop-shadow-[0_2px_16px_rgba(6,9,25,0.9)]">
                Membantu UMKM go-digital dengan website modern berarsitektur solid dan membimbing mahasiswa Informatika meraih gelar sarjana lewat sistem skripsi yang terstruktur dan siap diuji.
            </p>

            <!-- 2 Tombol CTA -->
            <div data-reveal="up" data-reveal-delay="130" class="hero-reveal w-full sm:w-auto flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#kontak" class="group w-full sm:w-auto min-h-[48px] inline-flex items-center justify-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:brightness-110 text-white px-7 py-3.5 rounded-xl text-base font-semibold shadow-[0_0_24px_-6px_rgba(34,211,238,0.45)] hover:shadow-[0_0_28px_-4px_rgba(34,211,238,0.65)] hover:-translate-y-0.5 transition-all duration-200">
                    <span>Konsultasi Gratis</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <a href="#portfolio" class="w-full sm:w-auto min-h-[48px] inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-[#0E1530]/80 backdrop-blur-md border border-slate-700 hover:border-cyan-400/60 text-slate-100 hover:text-cyan-300 text-base font-semibold transition-all duration-200">
                    <span>Lihat Karya Kami</span>
                    <span aria-hidden="true">&darr;</span>
                </a>
            </div>
        </div>

        <!-- Circuit Chip Tech Stack Bar (Centered) -->
        <div data-reveal="up" data-reveal-delay="195" class="hero-reveal mt-12 lg:mt-14 pt-8 border-t border-cyan-500/15 max-w-4xl mx-auto">
            <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3">
                <span class="bg-[#0E1530] border border-cyan-500/20 hover:border-cyan-400/60 font-tech-mono text-xs text-cyan-200 px-3.5 py-1.5 rounded-md transition-colors">Laravel 13</span>
                <span class="bg-[#0E1530] border border-cyan-500/20 hover:border-cyan-400/60 font-tech-mono text-xs text-cyan-200 px-3.5 py-1.5 rounded-md transition-colors">PHP 8.5</span>
                <span class="bg-[#0E1530] border border-cyan-500/20 hover:border-cyan-400/60 font-tech-mono text-xs text-cyan-200 px-3.5 py-1.5 rounded-md transition-colors">Tailwind CSS</span>
                <span class="bg-[#0E1530] border border-cyan-500/20 hover:border-cyan-400/60 font-tech-mono text-xs text-cyan-200 px-3.5 py-1.5 rounded-md transition-colors">MySQL</span>
                <span class="bg-[#0E1530] border border-cyan-500/20 hover:border-cyan-400/60 font-tech-mono text-xs text-cyan-200 px-3.5 py-1.5 rounded-md transition-colors">Sistem Informasi</span>
                <span class="bg-[#0E1530] border border-cyan-500/20 hover:border-cyan-400/60 font-tech-mono text-xs text-cyan-200 px-3.5 py-1.5 rounded-md transition-colors">E-Commerce</span>
            </div>
        </div>
    </div>
</section>

<!-- 2. PORTOFOLIO SECTION + MODAL GALERI DARK -->
<section id="portfolio"
    class="scroll-mt-20 py-16 md:py-24 bg-[#0A1026] border-t border-cyan-400/10"
    x-data="{
        isOpen: false,
        activeProject: null,
        currentImageIndex: 0,
        touchStartX: 0,
        touchEndX: 0,
        openModal(project) {
            this.activeProject = project;
            this.currentImageIndex = 0;
            this.isOpen = true;
            document.body.classList.add('overflow-hidden');
        },
        closeModal() {
            this.isOpen = false;
            document.body.classList.remove('overflow-hidden');
            setTimeout(() => {
                if (!this.isOpen) {
                    this.activeProject = null;
                    this.currentImageIndex = 0;
                }
            }, 300);
        },
        nextImage() {
            if (!this.activeProject || !this.activeProject.images || this.activeProject.images.length <= 1) return;
            this.currentImageIndex = (this.currentImageIndex + 1) % this.activeProject.images.length;
        },
        prevImage() {
            if (!this.activeProject || !this.activeProject.images || this.activeProject.images.length <= 1) return;
            this.currentImageIndex = (this.currentImageIndex - 1 + this.activeProject.images.length) % this.activeProject.images.length;
        },
        setCurrentImage(index) {
            this.currentImageIndex = index;
        },
        handleTouchStart(e) {
            if (!e.changedTouches || !e.changedTouches.length) return;
            this.touchStartX = e.changedTouches[0].screenX;
        },
        handleTouchEnd(e) {
            if (!e.changedTouches || !e.changedTouches.length) return;
            this.touchEndX = e.changedTouches[0].screenX;
            const diff = this.touchStartX - this.touchEndX;
            if (Math.abs(diff) > 40) {
                if (diff > 0) {
                    this.nextImage();
                } else {
                    this.prevImage();
                }
            }
        }
    }"
    @open-project-modal.window="openModal($event.detail)"
    @keydown.escape.window="closeModal()"
    @keydown.arrow-right.window="if (isOpen) nextImage()"
    @keydown.arrow-left.window="if (isOpen) prevImage()"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header & Filter Kategori Dark -->
        <div data-reveal="up" class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 md:mb-12">
            <div>
                <h2 class="font-tech-display text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight text-[#F8FAFC] mb-2.5">
                    Karya Pilihan Kami
                </h2>
                <p class="text-sm sm:text-base text-[#94A3B8] max-w-xl">
                    Kumpulan sistem manajemen bisnis, e-commerce, dan aplikasi skripsi yang telah selesai dikerjakan.
                </p>
            </div>

            @if($portfolioCategories->isNotEmpty())
                <div class="flex flex-wrap items-center gap-2" role="tablist" aria-label="Filter Kategori Portofolio">
                    <button type="button"
                            data-filter="all"
                            class="portfolio-filter-btn px-4 py-2 min-h-[40px] rounded-lg text-xs sm:text-sm font-medium border border-cyan-400 bg-cyan-500/15 text-cyan-300 transition-all">
                        Semua
                    </button>
                    @foreach($portfolioCategories as $category)
                        <button type="button"
                                data-filter="{{ $category }}"
                                class="portfolio-filter-btn px-4 py-2 min-h-[40px] rounded-lg text-xs sm:text-sm font-medium border border-slate-800 bg-[#0E1530]/70 text-slate-400 hover:border-cyan-400/40 hover:text-slate-200 transition-all">
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Grid Card Portofolio -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse ($projects as $project)
                @php
                    $allImageUrls = $project->all_image_urls;
                    $imageCount = count($allImageUrls);
                    $firstImageUrl = $project->first_image_url;

                    $projectData = [
                        'title' => $project->title,
                        'category' => $project->category,
                        'description' => $project->description,
                        'tech_stack' => is_array($project->tech_stack) ? $project->tech_stack : [],
                        'images' => $allImageUrls,
                        'image_url' => $firstImageUrl,
                        'url_link' => $project->url_link,
                    ];
                @endphp
                <article data-project-card
                         data-category="{{ $project->category }}"
                         data-reveal="up"
                         data-reveal-delay="{{ ($loop->index % 3) * 85 }}"
                         @click="openModal(@js($projectData))"
                         class="group bg-[#0D142C] rounded-2xl border border-slate-800/90 hover:border-cyan-400/50 hover:shadow-[0_0_30px_-10px_rgba(34,211,238,0.3)] hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden flex flex-col min-w-0">
                    <!-- Thumbnail 16:10 -->
                    <div class="aspect-[16/10] bg-[#050816] w-full relative flex items-center justify-center overflow-hidden border-b border-slate-800/80">
                        @if($firstImageUrl)
                            <img src="{{ $firstImageUrl }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                 onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                            <div class="hidden flex items-center justify-center w-full h-full text-slate-500 font-tech-mono text-xs">No Image</div>
                        @else
                            <div class="flex items-center justify-center w-full h-full text-slate-500 font-tech-mono text-xs">No Image</div>
                        @endif

                        <!-- Hover Overlay ("Buka Detail ↗") -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#060919]/85 via-[#060919]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4 pointer-events-none">
                            <span class="font-tech-mono text-xs font-medium text-cyan-300 bg-[#060919]/80 border border-cyan-400/30 px-3 py-1 rounded-md backdrop-blur-sm">
                                Buka Detail &#8599;
                            </span>
                        </div>

                        <!-- Category Badge Dark Glass -->
                        <span class="absolute top-3.5 right-3.5 bg-[#060919]/80 backdrop-blur-md text-cyan-300 border border-cyan-400/30 font-tech-mono text-[11px] font-medium px-2.5 py-1 rounded-md max-w-[calc(100%-1.75rem)] truncate z-10">
                            {{ $project->category }}
                        </span>

                        <!-- Badge Jumlah Foto -->
                        @if($imageCount > 1)
                            <span class="absolute bottom-3 right-3 bg-[#060919]/85 backdrop-blur-md text-slate-200 border border-slate-700/80 font-tech-mono text-[11px] font-medium px-2.5 py-1 rounded-md flex items-center gap-1.5 z-10">
                                <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $imageCount }} Foto</span>
                            </span>
                        @endif
                    </div>

                    <div class="p-5 sm:p-6 flex flex-col flex-grow min-w-0">
                        <h3 class="font-tech-display text-lg sm:text-xl font-bold text-[#F8FAFC] group-hover:text-cyan-300 transition-colors mb-2 break-words">
                            {{ $project->title }}
                        </h3>
                        <p class="text-[#94A3B8] mb-5 text-sm line-clamp-3 leading-relaxed break-words">
                            {{ $project->description }}
                        </p>

                        <div class="mt-auto">
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @if(is_array($project->tech_stack))
                                    @foreach($project->tech_stack as $tech)
                                        <span class="font-tech-mono text-[11px] bg-[#060919]/80 text-slate-300 border border-slate-800 px-2.5 py-1 rounded break-words">{{ $tech }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-2 pt-3.5 border-t border-slate-800/80 text-xs">
                                <span class="text-cyan-400 font-medium group-hover:text-cyan-300 inline-flex items-center gap-1 py-1 transition-colors">
                                    <span>Detail Proyek</span>
                                    <span class="group-hover:translate-x-0.5 transition-transform" aria-hidden="true">&rarr;</span>
                                </span>
                                @if($project->url_link)
                                    <a href="{{ $project->url_link }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       @click.stop
                                       onclick="event.stopPropagation()"
                                       class="inline-flex items-center gap-1 font-tech-mono text-[11px] text-slate-400 hover:text-cyan-300 hover:underline transition py-1">
                                        <span>Lihat Proyek</span>
                                        <span aria-hidden="true">&#8599;</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12 bg-[#0E1530]/60 rounded-2xl border border-slate-800 text-[#94A3B8]">
                    Belum ada portofolio yang ditambahkan.
                </div>
            @endforelse
        </div>

        <!-- Pesan kosong saat filter kategori tidak cocok -->
        <div id="portfolio-filter-empty" class="hidden text-center py-12 mt-4 bg-[#0E1530]/60 rounded-2xl border border-slate-800 text-[#94A3B8] text-sm">
            Belum ada proyek pada kategori ini.
        </div>
    </div>

    <!-- Modal Pop-up Detail Proyek & Galeri Slider (Tema Gelap Precision Tech) -->
    <div
        x-show="isOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-[#040712]/85 backdrop-blur-md flex items-center justify-center p-2 sm:p-6 lg:p-8"
        @click.self="closeModal()"
    >
        <!-- Modal Dialog Card -->
        <div
            x-show="isOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="bg-[#0B1126] border border-cyan-400/25 text-slate-100 rounded-2xl shadow-[0_0_50px_-15px_rgba(34,211,238,0.25)] w-[95vw] sm:w-full max-w-4xl max-h-[90vh] max-h-[90dvh] flex flex-col overflow-hidden relative"
            @click.stop
        >
            <!-- Modal Header (Sticky) -->
            <div class="flex items-center justify-between gap-2 px-4 py-3 sm:px-6 sm:py-4 border-b border-slate-800 bg-[#0B1126]/95 backdrop-blur-md sticky top-0 z-10 flex-shrink-0">
                <div class="flex items-center gap-2.5 min-w-0">
                    <span class="font-tech-mono uppercase tracking-wider text-xs font-medium text-cyan-300 bg-cyan-500/10 border border-cyan-400/30 px-3 py-1 rounded-md truncate" x-text="activeProject?.category"></span>
                </div>
                <button
                    type="button"
                    @click="closeModal()"
                    class="flex-shrink-0 text-slate-400 hover:text-white bg-slate-800/80 hover:bg-slate-700 border border-slate-700 p-2 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-xl transition focus:outline-none focus:ring-2 focus:ring-cyan-400/50"
                    aria-label="Tutup Modal"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div class="overflow-y-auto p-4 sm:p-6 space-y-4 sm:space-y-6 flex-1 min-h-0">
                <!-- Area Galeri / Image Slider Interaktif -->
                <div class="space-y-3">
                    <div
                        @touchstart.passive="handleTouchStart($event)"
                        @touchend="handleTouchEnd($event)"
                        class="w-full rounded-xl overflow-hidden bg-[#050816] border border-slate-800/90 relative flex items-center justify-center min-h-[180px] sm:min-h-[240px] select-none touch-pan-y"
                    >
                        <template x-if="activeProject?.images && activeProject.images.length > 0">
                            <div class="w-full relative flex items-center justify-center">
                                <img
                                    :src="activeProject.images[currentImageIndex]"
                                    :alt="activeProject.title"
                                    class="w-full max-h-[38vh] sm:max-h-[55vh] object-contain bg-[#050816] transition-opacity duration-200"
                                >

                                <!-- Indikator Nomor Foto -->
                                <template x-if="activeProject.images.length > 1">
                                    <div class="absolute top-2.5 left-2.5 sm:top-3 sm:left-3 bg-[#060919]/85 backdrop-blur-md text-cyan-200 border border-cyan-400/30 font-tech-mono text-xs font-medium px-2.5 py-1 rounded-md">
                                        <span x-text="(currentImageIndex + 1) + ' / ' + activeProject.images.length"></span>
                                    </div>
                                </template>

                                <!-- Tombol Panah Desktop Bertepi Cyan -->
                                <template x-if="activeProject.images.length > 1">
                                    <button
                                        type="button"
                                        @click.stop="prevImage()"
                                        class="hidden sm:flex items-center justify-center absolute left-3 top-1/2 -translate-y-1/2 bg-[#060919]/80 hover:bg-[#0E1530] text-cyan-300 border border-cyan-400/40 hover:border-cyan-400 p-2.5 rounded-full transition shadow-lg backdrop-blur-md focus:outline-none"
                                        aria-label="Foto Sebelumnya"
                                        title="Foto Sebelumnya (Panah Kiri)"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                </template>

                                <template x-if="activeProject.images.length > 1">
                                    <button
                                        type="button"
                                        @click.stop="nextImage()"
                                        class="hidden sm:flex items-center justify-center absolute right-3 top-1/2 -translate-y-1/2 bg-[#060919]/80 hover:bg-[#0E1530] text-cyan-300 border border-cyan-400/40 hover:border-cyan-400 p-2.5 rounded-full transition shadow-lg backdrop-blur-md focus:outline-none"
                                        aria-label="Foto Berikutnya"
                                        title="Foto Berikutnya (Panah Kanan)"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </template>
                            </div>
                        </template>

                        <!-- Placeholder jika tidak ada gambar -->
                        <template x-if="!activeProject?.images || activeProject.images.length === 0">
                            <div class="flex flex-col items-center justify-center py-12 sm:py-16 text-slate-500">
                                <svg class="w-12 h-12 sm:w-14 sm:h-14 mb-2 stroke-current opacity-50" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-tech-mono text-xs sm:text-sm">Tidak ada screenshot yang diunggah</span>
                            </div>
                        </template>
                    </div>

                    <!-- Kontrol Panah Khusus Layar HP -->
                    <template x-if="activeProject?.images && activeProject.images.length > 1">
                        <div class="flex sm:hidden items-center justify-between gap-2 pt-0.5">
                            <button
                                type="button"
                                @click.stop="prevImage()"
                                class="inline-flex items-center justify-center gap-1 px-3 py-2 min-w-[44px] min-h-[44px] rounded-xl border border-cyan-400/30 bg-[#0E1530] text-cyan-200 text-xs font-medium transition focus:outline-none"
                                aria-label="Foto Sebelumnya"
                            >
                                <span aria-hidden="true">&larr;</span>
                                <span>Sebelumnya</span>
                            </button>
                            <span class="font-tech-mono text-xs text-slate-400" x-text="(currentImageIndex + 1) + ' / ' + activeProject.images.length"></span>
                            <button
                                type="button"
                                @click.stop="nextImage()"
                                class="inline-flex items-center justify-center gap-1 px-3 py-2 min-w-[44px] min-h-[44px] rounded-xl border border-cyan-400/30 bg-[#0E1530] text-cyan-200 text-xs font-medium transition focus:outline-none"
                                aria-label="Foto Berikutnya"
                            >
                                <span>Berikutnya</span>
                                <span aria-hidden="true">&rarr;</span>
                            </button>
                        </div>
                    </template>

                    <!-- Deretan Thumbnail -->
                    <template x-if="activeProject?.images && activeProject.images.length > 1">
                        <div class="flex items-center gap-2.5 overflow-x-auto pb-2 pt-1 px-1 touch-pan-x">
                            <template x-for="(img, idx) in activeProject.images" :key="idx">
                                <button
                                    type="button"
                                    @click="setCurrentImage(idx)"
                                    class="relative flex-shrink-0 w-20 h-14 rounded-lg overflow-hidden border transition-all cursor-pointer focus:outline-none"
                                    :class="currentImageIndex === idx ? 'border-cyan-400 ring-2 ring-cyan-400 opacity-100' : 'border-slate-800 opacity-55 hover:opacity-100 hover:border-slate-600'"
                                    :title="'Buka foto ke-' + (idx + 1)"
                                >
                                    <img :src="img" :alt="'Thumbnail ' + (idx + 1)" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Judul & Tech Stack -->
                <div>
                    <h3 class="font-tech-display text-xl sm:text-2xl md:text-3xl font-bold tracking-tight text-[#F8FAFC] mb-3 break-words" x-text="activeProject?.title"></h3>
                    <div class="flex flex-wrap gap-2 pt-1">
                        <template x-for="(tech, index) in (activeProject?.tech_stack || [])" :key="index">
                            <span class="font-tech-mono text-xs bg-[#060919] text-cyan-200 font-medium px-2.5 py-1 rounded-md border border-cyan-500/20 break-words" x-text="tech"></span>
                        </template>
                    </div>
                </div>

                <!-- Deskripsi Lengkap -->
                <div class="border-t border-slate-800 pt-4 sm:pt-5">
                    <h4 class="font-tech-mono text-xs uppercase tracking-wider text-slate-400 mb-2 sm:mb-3">Deskripsi Lengkap</h4>
                    <p class="text-[#94A3B8] text-sm sm:text-base leading-relaxed whitespace-pre-line break-words" x-text="activeProject?.description"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-4 py-3 sm:px-6 sm:py-4 bg-[#080D1F] border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-2.5 sm:gap-3 flex-shrink-0">
                <div class="w-full sm:w-auto">
                    <template x-if="activeProject?.url_link">
                        <a
                            :href="activeProject.url_link"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 hover:brightness-110 text-white font-semibold px-5 py-2.5 min-h-[44px] rounded-xl transition-all shadow-[0_0_20px_-6px_rgba(34,211,238,0.45)] w-full sm:w-auto justify-center text-sm"
                        >
                            <span>Kunjungi Proyek / Live Demo</span>
                            <span aria-hidden="true">&#8599;</span>
                        </a>
                    </template>
                </div>

                <button
                    type="button"
                    @click="closeModal()"
                    class="w-full sm:w-auto px-5 py-2.5 min-h-[44px] rounded-xl border border-slate-700 bg-[#0E1530] text-slate-200 font-medium hover:border-cyan-400/50 hover:text-white transition-colors text-center text-sm"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</section>

<!-- 3. ALUR PENGERJAAN (CIRCUIT NODE TIMELINE) -->
<section id="proses" class="scroll-mt-20 py-16 md:py-24 bg-[#060919] border-t border-cyan-400/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-reveal="up" class="text-center max-w-2xl mx-auto mb-12 md:mb-16">
            <h2 class="font-tech-display text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight text-[#F8FAFC] mb-3.5">
                Alur Pengerjaan
            </h2>
            <p class="text-sm sm:text-base text-[#94A3B8] leading-relaxed">
                Proses terukur dari perancangan arsitektur hingga peluncuran dan pendampingan penuh.
            </p>
        </div>

        <div class="relative">
            <!-- Garis Horizontal Sirkuit Penghubung Node (Desktop) -->
            <div data-reveal="line-x" data-reveal-delay="120" class="hidden md:block absolute top-6 left-[16.66%] right-[16.66%] h-px bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 opacity-70 pointer-events-none"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 relative">
                <!-- Node 01 -->
                <div data-reveal="up" data-reveal-delay="0" class="flex flex-col items-start md:items-center text-left md:text-center">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-12 h-12 rounded-full bg-[#0E1530] border border-cyan-400/60 flex items-center justify-center shadow-[0_0_16px_rgba(34,211,238,0.35)]">
                            <span class="w-3 h-3 rounded-full bg-cyan-400 shadow-[0_0_10px_#22D3EE]"></span>
                        </span>
                    </div>
                    <div class="w-full bg-[#0E1530]/80 backdrop-blur-md border border-cyan-400/15 rounded-2xl p-6 h-full">
                        <p class="font-tech-mono text-xs text-cyan-400 mb-2">01. KONSULTASI</p>
                        <h3 class="font-tech-display text-lg font-bold text-[#F8FAFC] mb-2">
                            01. Konsultasi &amp; Blueprint
                        </h3>
                        <p class="text-sm text-[#94A3B8] leading-relaxed">
                            Diskusi kebutuhan fitur bisnis, perancangan ERD &amp; alur sistem, serta kesepakatan target deadline secara transparan.
                        </p>
                    </div>
                </div>

                <!-- Node 02 -->
                <div data-reveal="up" data-reveal-delay="90" class="flex flex-col items-start md:items-center text-left md:text-center">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-12 h-12 rounded-full bg-[#0E1530] border border-blue-400/60 flex items-center justify-center shadow-[0_0_16px_rgba(59,130,246,0.35)]">
                            <span class="w-3 h-3 rounded-full bg-blue-400 shadow-[0_0_10px_#60A5FA]"></span>
                        </span>
                    </div>
                    <div class="w-full bg-[#0E1530]/80 backdrop-blur-md border border-cyan-400/15 rounded-2xl p-6 h-full">
                        <p class="font-tech-mono text-xs text-blue-400 mb-2">02. BUILD</p>
                        <h3 class="font-tech-display text-lg font-bold text-[#F8FAFC] mb-2">
                            02. Development &amp; Preview
                        </h3>
                        <p class="text-sm text-[#94A3B8] leading-relaxed">
                            Pengembangan backend Laravel, database, dan antarmuka responsif disertai demo berkala untuk memastikan hasil sesuai ekspektasi.
                        </p>
                    </div>
                </div>

                <!-- Node 03 -->
                <div data-reveal="up" data-reveal-delay="180" class="flex flex-col items-start md:items-center text-left md:text-center">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-12 h-12 rounded-full bg-[#0E1530] border border-purple-400/60 flex items-center justify-center shadow-[0_0_16px_rgba(168,85,247,0.35)]">
                            <span class="w-3 h-3 rounded-full bg-purple-400 shadow-[0_0_10px_#C084FC]"></span>
                        </span>
                    </div>
                    <div class="w-full bg-[#0E1530]/80 backdrop-blur-md border border-cyan-400/15 rounded-2xl p-6 h-full">
                        <p class="font-tech-mono text-xs text-purple-400 mb-2">03. DEPLOY</p>
                        <h3 class="font-tech-display text-lg font-bold text-[#F8FAFC] mb-2">
                            03. Launch &amp; Pendampingan
                        </h3>
                        <p class="text-sm text-[#94A3B8] leading-relaxed">
                            Penyerahan 100% source code &amp; database, sesi bedah kode khusus skripsi, serta dukungan garansi perbaikan bug selama 30 hari.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. LAYANAN & HARGA SECTION -->
<section id="layanan" class="scroll-mt-20 py-16 md:py-24 bg-[#0A1026] border-t border-cyan-400/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-reveal="up" class="text-center max-w-2xl mx-auto mb-12 md:mb-16">
            <h2 class="font-tech-display text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight text-[#F8FAFC] mb-3.5">
                Layanan &amp; Harga
            </h2>
            <p class="text-sm sm:text-base text-[#94A3B8] leading-relaxed">
                Pilih paket layanan sesuai target proyek Anda. Klik tombol paket untuk langsung mengisi form pemesanan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 items-stretch">
            <!-- Paket 1: Web UMKM / Profil Bisnis -->
            <div data-reveal="up" data-reveal-delay="0" class="bg-[#0E1530]/80 backdrop-blur-md rounded-2xl border border-cyan-400/15 hover:border-cyan-400/45 p-6 sm:p-8 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="mb-4">
                        <span class="inline-block font-tech-mono text-xs text-cyan-300 bg-cyan-500/10 border border-cyan-400/20 px-2.5 py-0.5 rounded">Min. 7 Hari</span>
                    </div>
                    <h3 class="font-tech-display text-xl font-bold text-[#F8FAFC] mb-2">Web UMKM / Profil Bisnis</h3>
                    <p class="text-[#94A3B8] text-sm mb-6 leading-relaxed">Cocok untuk memperluas jangkauan digital bisnis Anda.</p>
                    <div class="pb-6 mb-6 border-b border-slate-800">
                        <span class="font-tech-display text-2xl sm:text-3xl font-bold text-[#F8FAFC]">Mulai Rp 1,5 Jt</span>
                    </div>
                    <ul class="space-y-3.5 mb-8 text-slate-300 text-sm">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Desain Responsif &amp; Modern</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Domain &amp; Hosting 1 Tahun</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Integrasi WhatsApp &amp; Maps</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Basic SEO Optimization</span>
                        </li>
                    </ul>
                </div>

                <button type="button"
                        onclick="selectServicePackage('Web UMKM / Profil Bisnis')"
                        class="w-full min-h-[44px] inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-cyan-400/30 bg-[#060919]/80 hover:bg-cyan-500/15 hover:border-cyan-400 text-cyan-200 hover:text-white font-semibold text-sm transition-all duration-200">
                    <span>Pilih Paket Ini</span>
                    <span aria-hidden="true">&rarr;</span>
                </button>
            </div>

            <!-- Paket 2: Web Sistem / E-Commerce (Gradient Border 1.5px Cyan -> Violet) -->
            <div data-reveal="up" data-reveal-delay="90" class="p-[1.5px] rounded-2xl bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-500 shadow-[0_0_40px_-12px_rgba(34,211,238,0.35)] md:-translate-y-4">
                <div class="bg-[#0B1126] rounded-[calc(1rem-1.5px)] p-6 sm:p-8 h-full flex flex-col justify-between relative overflow-hidden">
                    <!-- Subtle Top Glow -->
                    <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-64 h-32 bg-cyan-400/15 blur-2xl pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="mb-4">
                            <span class="inline-block bg-gradient-to-r from-cyan-400 to-purple-500 text-[#040712] font-tech-mono text-[11px] font-bold px-2.5 py-0.5 rounded uppercase tracking-wider">
                                POPULER
                            </span>
                        </div>
                        <h3 class="font-tech-display text-xl font-bold text-[#F8FAFC] mb-2">Web Sistem / E-Commerce</h3>
                        <p class="text-[#94A3B8] text-sm mb-6 leading-relaxed">Solusi custom untuk operasional dan penjualan online.</p>
                        <div class="pb-6 mb-6 border-b border-slate-800">
                            <span class="font-tech-display text-2xl sm:text-3xl font-bold text-[#F8FAFC]">Mulai Rp 4 Jt</span>
                        </div>
                        <ul class="space-y-3.5 mb-8 text-slate-200 text-sm">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Fitur Custom Sesuai Request</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Database &amp; Arsitektur Solid</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Payment Gateway Integration</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Dashboard Admin &amp; Laporan</span>
                            </li>
                        </ul>
                    </div>

                    <button type="button"
                            onclick="selectServicePackage('Web Sistem / E-Commerce')"
                            class="relative z-10 w-full min-h-[44px] inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 hover:brightness-110 text-white font-semibold text-sm shadow-[0_0_24px_-6px_rgba(34,211,238,0.5)] transition-all duration-200">
                        <span>Pilih Paket Ini</span>
                        <span aria-hidden="true">&rarr;</span>
                    </button>
                </div>
            </div>

            <!-- Paket 3: Joki / Skripsi IT -->
            <div data-reveal="up" data-reveal-delay="180" class="bg-[#0E1530]/80 backdrop-blur-md rounded-2xl border border-cyan-400/15 hover:border-purple-400/45 p-6 sm:p-8 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="mb-4">
                        <span class="inline-block font-tech-mono text-xs text-purple-300 bg-purple-500/10 border border-purple-400/20 px-2.5 py-0.5 rounded">Min. 3 Minggu</span>
                    </div>
                    <h3 class="font-tech-display text-xl font-bold text-[#F8FAFC] mb-2">Joki / Skripsi IT</h3>
                    <p class="text-[#94A3B8] text-sm mb-6 leading-relaxed">Pendampingan penuh dari perancangan hingga sidang.</p>
                    <div class="pb-6 mb-6 border-b border-slate-800">
                        <span class="font-tech-display text-2xl sm:text-3xl font-bold text-[#F8FAFC]">Mulai Rp 2,5 Jt</span>
                    </div>
                    <ul class="space-y-3.5 mb-8 text-slate-300 text-sm">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Pembuatan Aplikasi/Sistem</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Bebas Revisi Mayor (S&amp;K)</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Bimbingan Source Code</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Dokumentasi UML &amp; Flowchart</span>
                        </li>
                    </ul>
                </div>

                <button type="button"
                        onclick="selectServicePackage('Joki / Pendampingan Skripsi IT')"
                        class="w-full min-h-[44px] inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-cyan-400/30 bg-[#060919]/80 hover:bg-purple-500/15 hover:border-purple-400 text-cyan-200 hover:text-white font-semibold text-sm transition-all duration-200">
                    <span>Pilih Paket Ini</span>
                    <span aria-hidden="true">&rarr;</span>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- 5. FAQ SECTION (ACCORDION DARK TECH) -->
<section id="faq" class="scroll-mt-20 py-16 md:py-24 bg-[#060919] border-t border-cyan-400/10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-reveal="up" class="text-center mb-10 md:mb-14">
            <h2 class="font-tech-display text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight text-[#F8FAFC] mb-3.5">
                Pertanyaan yang Sering Diajukan
            </h2>
            <p class="text-sm sm:text-base text-[#94A3B8] max-w-2xl mx-auto leading-relaxed">
                Masih ada keraguan? Berikut beberapa pertanyaan umum seputar layanan pembuatan website dan pendampingan skripsi IT kami.
            </p>
        </div>

        <div class="space-y-3 sm:space-y-4" x-data="{ active: null }">
            <!-- FAQ 1 -->
            <div data-reveal="up" data-reveal-delay="0" class="rounded-xl overflow-hidden transition-all duration-200 bg-[#0C132A]/70 border border-slate-800 hover:border-cyan-500/30" :class="active === 1 ? 'border-l-2 border-l-cyan-400 border-cyan-500/40 bg-[#0E1530]/90' : ''">
                <button
                    type="button"
                    @click="active = (active === 1 ? null : 1)"
                    class="w-full px-4 py-4 sm:px-6 sm:py-5 min-h-[44px] text-left flex justify-between items-center focus:outline-none transition-colors"
                >
                    <span class="font-tech-display font-semibold text-sm sm:text-base md:text-lg text-[#F8FAFC] pr-3">
                        Berapa lama estimasi pengerjaan website atau sistem skripsi?
                    </span>
                    <span class="flex-shrink-0 text-cyan-400 transition-transform duration-200" :class="active === 1 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                <div
                    x-show="active === 1"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="px-4 pb-4 sm:px-6 sm:pb-5 pt-2 text-[#94A3B8] text-sm md:text-base leading-relaxed border-t border-slate-800/80"
                >
                    Waktu pengerjaan tergantung pada paket yang dipilih:
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li><strong class="text-[#F8FAFC]">Web UMKM / Profil Bisnis:</strong> 3 &ndash; 7 hari kerja.</li>
                        <li><strong class="text-[#F8FAFC]">Web Sistem / E-Commerce:</strong> 2 &ndash; 4 minggu (tergantung kompleksitas fitur).</li>
                        <li><strong class="text-[#F8FAFC]">Pendampingan Skripsi IT:</strong> Fleksibel menyesuaikan jadwal bimbingan/sidang Anda, umumnya 1 &ndash; 3 minggu.</li>
                    </ul>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div data-reveal="up" data-reveal-delay="65" class="rounded-xl overflow-hidden transition-all duration-200 bg-[#0C132A]/70 border border-slate-800 hover:border-cyan-500/30" :class="active === 2 ? 'border-l-2 border-l-cyan-400 border-cyan-500/40 bg-[#0E1530]/90' : ''">
                <button
                    type="button"
                    @click="active = (active === 2 ? null : 2)"
                    class="w-full px-4 py-4 sm:px-6 sm:py-5 min-h-[44px] text-left flex justify-between items-center focus:outline-none transition-colors"
                >
                    <span class="font-tech-display font-semibold text-sm sm:text-base md:text-lg text-[#F8FAFC] pr-3">
                        Apakah saya akan mendapatkan 100% source code dan database?
                    </span>
                    <span class="flex-shrink-0 text-cyan-400 transition-transform duration-200" :class="active === 2 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                <div
                    x-show="active === 2"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="px-4 pb-4 sm:px-6 sm:pb-5 pt-2 text-[#94A3B8] text-sm md:text-base leading-relaxed border-t border-slate-800/80"
                >
                    Tentu saja! Setelah pelunasan, seluruh <strong class="text-[#F8FAFC]">source code</strong>, <strong class="text-[#F8FAFC]">file database (.sql)</strong>, dan aset pendukung akan diserahkan secara lengkap tanpa enkripsi atau batasan. Anda memiliki hak milik penuh atas aplikasi tersebut.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div data-reveal="up" data-reveal-delay="130" class="rounded-xl overflow-hidden transition-all duration-200 bg-[#0C132A]/70 border border-slate-800 hover:border-cyan-500/30" :class="active === 3 ? 'border-l-2 border-l-cyan-400 border-cyan-500/40 bg-[#0E1530]/90' : ''">
                <button
                    type="button"
                    @click="active = (active === 3 ? null : 3)"
                    class="w-full px-4 py-4 sm:px-6 sm:py-5 min-h-[44px] text-left flex justify-between items-center focus:outline-none transition-colors"
                >
                    <span class="font-tech-display font-semibold text-sm sm:text-base md:text-lg text-[#F8FAFC] pr-3">
                        Bagaimana alur dan sistem pembayarannya?
                    </span>
                    <span class="flex-shrink-0 text-cyan-400 transition-transform duration-200" :class="active === 3 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                <div
                    x-show="active === 3"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="px-4 pb-4 sm:px-6 sm:pb-5 pt-2 text-[#94A3B8] text-sm md:text-base leading-relaxed border-t border-slate-800/80"
                >
                    Sistem pembayaran dirancang aman dan transparan:
                    <ol class="list-decimal list-inside mt-2 space-y-1">
                        <li><strong class="text-[#F8FAFC]">Konsultasi &amp; Kesepakatan:</strong> Diskusi kebutuhan fitur dan penentuan estimasi harga.</li>
                        <li><strong class="text-[#F8FAFC]">Down Payment (DP):</strong> Pembayaran uang muka sebesar 30% &ndash; 50% untuk mulai pengerjaan.</li>
                        <li><strong class="text-[#F8FAFC]">Progress &amp; Demo:</strong> Kami mendemokan aplikasi yang sudah berjalan via live server atau video call.</li>
                        <li><strong class="text-[#F8FAFC]">Pelunasan &amp; Serah Terima:</strong> Pelunasan sisa tagihan, dilanjutkan serah terima source code dan bimbingan setup.</li>
                    </ol>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div data-reveal="up" data-reveal-delay="0" class="rounded-xl overflow-hidden transition-all duration-200 bg-[#0C132A]/70 border border-slate-800 hover:border-cyan-500/30" :class="active === 4 ? 'border-l-2 border-l-cyan-400 border-cyan-500/40 bg-[#0E1530]/90' : ''">
                <button
                    type="button"
                    @click="active = (active === 4 ? null : 4)"
                    class="w-full px-4 py-4 sm:px-6 sm:py-5 min-h-[44px] text-left flex justify-between items-center focus:outline-none transition-colors"
                >
                    <span class="font-tech-display font-semibold text-sm sm:text-base md:text-lg text-[#F8FAFC] pr-3">
                        Untuk pendampingan skripsi IT, apa saja yang saya dapatkan?
                    </span>
                    <span class="flex-shrink-0 text-cyan-400 transition-transform duration-200" :class="active === 4 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                <div
                    x-show="active === 4"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="px-4 pb-4 sm:px-6 sm:pb-5 pt-2 text-[#94A3B8] text-sm md:text-base leading-relaxed border-t border-slate-800/80"
                >
                    Anda mendapatkan pendampingan menyeluruh dari perancangan hingga dinyatakan lulus sidang:
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li>Aplikasi siap pakai sesuai metode &amp; algoritma skripsi (misal: SPK AHP/TOPSIS/SAW, Machine Learning, GIS, dll).</li>
                        <li>Diagram UML (Use Case, Activity, Sequence, Class Diagram) &amp; ERD Database.</li>
                        <li>Sesi bedah koding (1-on-1 penjelasan alur program agar percaya diri menghadapi pertanyaan penguji).</li>
                        <li>Garansi revisi dari dosen pembimbing maupun penguji.</li>
                    </ul>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div data-reveal="up" data-reveal-delay="65" class="rounded-xl overflow-hidden transition-all duration-200 bg-[#0C132A]/70 border border-slate-800 hover:border-cyan-500/30" :class="active === 5 ? 'border-l-2 border-l-cyan-400 border-cyan-500/40 bg-[#0E1530]/90' : ''">
                <button
                    type="button"
                    @click="active = (active === 5 ? null : 5)"
                    class="w-full px-4 py-4 sm:px-6 sm:py-5 min-h-[44px] text-left flex justify-between items-center focus:outline-none transition-colors"
                >
                    <span class="font-tech-display font-semibold text-sm sm:text-base md:text-lg text-[#F8FAFC] pr-3">
                        Apakah ada garansi jika terjadi error atau bug setelah serah terima?
                    </span>
                    <span class="flex-shrink-0 text-cyan-400 transition-transform duration-200" :class="active === 5 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                <div
                    x-show="active === 5"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="px-4 pb-4 sm:px-6 sm:pb-5 pt-2 text-[#94A3B8] text-sm md:text-base leading-relaxed border-t border-slate-800/80"
                >
                    Ada! Kami memberikan <strong class="text-[#F8FAFC]">garansi perbaikan bug/error gratis selama 30 hari</strong> setelah proyek diserahkan. Jika ada kendala teknis atau fungsi yang tidak berjalan sesuai kesepakatan awal, kami akan segera memperbaikinya tanpa biaya tambahan.
                </div>
            </div>

            <!-- FAQ 6 -->
            <div data-reveal="up" data-reveal-delay="130" class="rounded-xl overflow-hidden transition-all duration-200 bg-[#0C132A]/70 border border-slate-800 hover:border-cyan-500/30" :class="active === 6 ? 'border-l-2 border-l-cyan-400 border-cyan-500/40 bg-[#0E1530]/90' : ''">
                <button
                    type="button"
                    @click="active = (active === 6 ? null : 6)"
                    class="w-full px-4 py-4 sm:px-6 sm:py-5 min-h-[44px] text-left flex justify-between items-center focus:outline-none transition-colors"
                >
                    <span class="font-tech-display font-semibold text-sm sm:text-base md:text-lg text-[#F8FAFC] pr-3">
                        Bagaimana cara memulai konsultasi dan pemesanan?
                    </span>
                    <span class="flex-shrink-0 text-cyan-400 transition-transform duration-200" :class="active === 6 ? 'rotate-180' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                <div
                    x-show="active === 6"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="px-4 pb-4 sm:px-6 sm:pb-5 pt-2 text-[#94A3B8] text-sm md:text-base leading-relaxed border-t border-slate-800/80"
                >
                    Sangat mudah! Anda cukup mengisi formulir pemesanan di bawah ini atau klik tombol <strong class="text-[#F8FAFC]">"Konsultasi Gratis"</strong> di bagian atas untuk langsung tersambung ke WhatsApp Admin. Konsultasi awal 100% gratis tanpa komitmen.
                </div>
            </div>
        </div>

        <!-- CTA Banner FAQ -->
        <div data-reveal="up" class="mt-10 sm:mt-12 bg-[#0E1530]/80 backdrop-blur-md rounded-2xl p-6 sm:p-8 border border-cyan-400/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-tech-display text-lg font-bold text-[#F8FAFC] mb-1">Masih memiliki pertanyaan lain?</h3>
                <p class="text-sm text-[#94A3B8]">Diskusikan ide sistem atau kebutuhan teknis skripsi Anda langsung dengan tim kami.</p>
            </div>
            <a href="#kontak" class="w-full sm:w-auto min-h-[44px] inline-flex items-center justify-center gap-2 bg-[#060919] border border-cyan-400/40 hover:border-cyan-300 text-cyan-300 hover:text-white font-semibold px-6 py-2.5 rounded-xl transition-all text-sm flex-shrink-0">
                <span>Tanya Langsung ke Kami</span>
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- 6. FORM PEMESANAN (DARK TECH BRIEF DENGAN CORNER BRACKETS) -->
<section id="kontak" class="scroll-mt-20 py-16 md:py-24 bg-[#0A1026] border-t border-cyan-400/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Kontainer dengan Tech Corner Brackets -->
        <div class="relative bg-[#0E1530]/80 backdrop-blur-md border border-cyan-400/20 rounded-2xl p-5 sm:p-8 lg:p-12 shadow-[0_0_50px_-20px_rgba(34,211,238,0.25)]">
            <!-- Garis Siku Tech Corner Brackets -->
            <span class="pointer-events-none absolute -top-px -left-px w-5 h-5 border-t-2 border-l-2 border-cyan-400 rounded-tl-2xl" aria-hidden="true"></span>
            <span class="pointer-events-none absolute -top-px -right-px w-5 h-5 border-t-2 border-r-2 border-cyan-400 rounded-tr-2xl" aria-hidden="true"></span>
            <span class="pointer-events-none absolute -bottom-px -left-px w-5 h-5 border-b-2 border-l-2 border-purple-400 rounded-bl-2xl" aria-hidden="true"></span>
            <span class="pointer-events-none absolute -bottom-px -right-px w-5 h-5 border-b-2 border-r-2 border-purple-400 rounded-br-2xl" aria-hidden="true"></span>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                <!-- Kolom Kiri: Ajakan Konsultasi & Jaminan -->
                <div data-reveal="up" data-reveal-delay="0" class="lg:col-span-5 space-y-6">
                    <div>
                        <h2 class="font-tech-display text-2xl sm:text-3xl font-bold tracking-tight text-[#F8FAFC] mb-3.5 leading-snug">
                            Mulai Proyek Anda!
                        </h2>
                        <p class="text-sm sm:text-base text-[#94A3B8] leading-relaxed">
                            Isi form di samping, sistem akan secara otomatis menghubungkan Anda ke WhatsApp Admin dengan ringkasan pesanan.
                        </p>
                    </div>

                    <div class="space-y-4 border-t border-slate-800 pt-6">
                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-lg bg-cyan-500/10 border border-cyan-400/25 text-cyan-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="font-tech-display text-sm font-bold text-[#F8FAFC]">Respon Cepat via WhatsApp</h3>
                                <p class="text-xs text-[#94A3B8] mt-0.5 leading-relaxed">Ringkasan order terformat otomatis agar konsultasi langsung fokus pada solusi.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-lg bg-purple-500/10 border border-purple-400/25 text-purple-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="font-tech-display text-sm font-bold text-[#F8FAFC]">Jaminan Pengerjaan</h3>
                                <p class="text-xs text-[#94A3B8] mt-0.5 leading-relaxed">100% full source code &amp; database, garansi perbaikan bug 30 hari, serta pendampingan revisi.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-400/25 text-blue-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="font-tech-display text-sm font-bold text-[#F8FAFC]">Estimasi Waktu Terjaga</h3>
                                <p class="text-xs text-[#94A3B8] mt-0.5 leading-relaxed">Deadline otomatis menyesuaikan kompleksitas paket agar kualitas kode tidak dikorbankan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Form Pemesanan Dark Mode -->
                <div data-reveal="up" data-reveal-delay="100" class="lg:col-span-7">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-950/60 border border-red-500/50 border-l-4 border-l-red-500 p-4 rounded-xl">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-semibold text-red-200">Terdapat kesalahan pada isian Anda:</h3>
                                    <ul class="mt-1 text-sm text-red-300 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('order.store') }}" method="POST" class="space-y-5"
                        x-data="{
                            service: '{{ old('service_category', '') }}',
                            deadline: '{{ old('deadline_date', '') }}',
                            minDate: '',
                            formattedMinDate: '',
                            infoText: '',
                            updateDeadline() {
                                let days = 0;
                                if (this.service === 'Web UMKM / Profil Bisnis') {
                                    days = 7;
                                    this.infoText = 'Estimasi minimal pengerjaan: 7 hari kerja';
                                } else if (this.service === 'Web Sistem / E-Commerce') {
                                    days = 28;
                                    this.infoText = 'Estimasi minimal pengerjaan: 4 minggu (28 hari)';
                                } else if (this.service === 'Joki / Pendampingan Skripsi IT') {
                                    days = 21;
                                    this.infoText = 'Estimasi minimal pengerjaan: 3 minggu (21 hari)';
                                }

                                if (days > 0) {
                                    const target = new Date();
                                    target.setDate(target.getDate() + days);
                                    const yyyy = target.getFullYear();
                                    const mm = String(target.getMonth() + 1).padStart(2, '0');
                                    const dd = String(target.getDate()).padStart(2, '0');
                                    this.minDate = `${yyyy}-${mm}-${dd}`;

                                    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    this.formattedMinDate = `${target.getDate()} ${months[target.getMonth()]} ${yyyy}`;

                                    this.deadline = this.minDate;
                                } else {
                                    this.minDate = '';
                                    this.formattedMinDate = '';
                                    this.infoText = '';
                                    this.deadline = '';
                                }
                            },
                            init() {
                                if (this.service) {
                                    const oldDeadline = this.deadline;
                                    this.updateDeadline();
                                    if (oldDeadline && oldDeadline >= this.minDate) {
                                        this.deadline = oldDeadline;
                                    }
                                }
                            }
                        }">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-200 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="w-full min-h-[44px] text-base bg-[#060919] border border-slate-700/80 text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl px-4 py-2.5 transition">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-200 mb-2">Nomor WhatsApp / HP</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full min-h-[44px] text-base bg-[#060919] border border-slate-700/80 text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl px-4 py-2.5 transition">
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-200 mb-2">Pilih Layanan</label>
                                <select name="service_category" required x-model="service" @change="updateDeadline()" class="w-full min-h-[44px] text-base bg-[#060919] border border-slate-700/80 text-white focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl px-4 py-2.5 transition">
                                    <option class="bg-[#0B1126] text-slate-400" value="" disabled selected>-- Pilih Kategori --</option>
                                    <option class="bg-[#0B1126] text-white" value="Web UMKM / Profil Bisnis">Web UMKM / Profil Bisnis (Min. 7 hari)</option>
                                    <option class="bg-[#0B1126] text-white" value="Web Sistem / E-Commerce">Web Sistem / E-Commerce (Min. 4 minggu)</option>
                                    <option class="bg-[#0B1126] text-white" value="Joki / Pendampingan Skripsi IT">Joki / Pendampingan Skripsi IT (Min. 3 minggu)</option>
                                </select>
                                @error('service_category')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-200 mb-2">Deadline / Target Selesai</label>
                                <input type="date" name="deadline_date" required x-model="deadline" :min="minDate" :disabled="!service"
                                    class="w-full min-h-[44px] text-base bg-[#060919] border border-slate-700/80 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl px-4 py-2.5 transition-colors"
                                    :class="!service ? 'opacity-55 cursor-not-allowed text-slate-500' : 'text-white'">

                                <!-- Info Estimasi Realtime -->
                                <div class="mt-2" x-show="service" x-cloak>
                                    <p class="text-xs text-cyan-300 flex items-center gap-1.5 font-medium bg-cyan-500/10 px-3 py-1.5 rounded-lg border border-cyan-400/25">
                                        <svg class="w-4 h-4 text-cyan-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span><span x-text="infoText"></span> &bull; paling cepat tgl <strong class="text-white" x-text="formattedMinDate"></strong></span>
                                    </p>
                                </div>
                                <div class="mt-2" x-show="!service">
                                    <p class="text-xs text-slate-400 bg-[#060919]/70 px-3 py-1.5 rounded-lg border border-slate-800 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-cyan-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Pilih layanan terlebih dahulu untuk membuka pilihan tanggal.</span>
                                    </p>
                                </div>
                                @error('deadline_date')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-200 mb-2">Deskripsi Kebutuhan / Judul Skripsi</label>
                            <textarea name="description" rows="4" required class="w-full min-h-[115px] text-base bg-[#060919] border border-slate-700/80 text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl px-4 py-2.5 transition" placeholder="Ceritakan detail proyek atau permasalahan yang ingin diselesaikan...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full min-h-[48px] inline-flex items-center justify-center gap-2.5 text-base bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 hover:brightness-110 text-white font-semibold py-3.5 px-6 rounded-xl shadow-[0_0_24px_-6px_rgba(34,211,238,0.5)] focus:outline-none focus:ring-2 focus:ring-cyan-400/50 transition-all duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 2c-5.516 0-9.969 4.453-9.969 9.969 0 1.766.453 3.484 1.328 5l-1.39 5.063 5.188-1.359a9.93 9.93 0 004.844 1.25c5.516 0 9.969-4.453 9.969-9.969S17.547 2 12.031 2zm5.813 14.141c-.25.703-1.438 1.344-2 1.422-.516.078-1.172.109-1.891-.125-.438-.141-.984-.328-1.688-.641-2.969-1.281-4.906-4.297-5.047-4.5-.141-.188-1.203-1.609-1.203-3.063s.766-2.172 1.031-2.469c.266-.297.578-.375.781-.375s.391 0 .563.016c.188.016.438-.078.672.5.25.594.844 2.063.922 2.219.078.156.125.328.016.531-.109.203-.156.328-.313.5-.156.172-.328.391-.469.531-.156.156-.313.328-.141.641.172.313.781 1.297 1.672 2.094 1.156 1.031 2.125 1.359 2.438 1.516.313.156.484.125.672-.078.188-.203.781-.906.984-1.219.203-.313.406-.266.688-.156.281.109 1.797.844 2.109 1 .313.156.516.234.594.359.078.125.078.734-.172 1.438z"/>
                            </svg>
                            <span>Kirim Pesanan ke WhatsApp Admin</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vanilla JS: Filter Kategori & Auto-Select Paket Layanan (Scroll system di resources/js/app.js) -->
<script>
    function selectServicePackage(packageName) {
        const selectEl = document.querySelector('#kontak select[name="service_category"]');
        if (selectEl) {
            selectEl.value = packageName;
            selectEl.dispatchEvent(new Event('input', { bubbles: true }));
            selectEl.dispatchEvent(new Event('change', { bubbles: true }));
        }

        const kontakSection = document.getElementById('kontak');
        if (kontakSection) {
            kontakSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        setTimeout(function () {
            const nameInput = document.querySelector('#kontak input[name="name"]');
            if (nameInput) {
                nameInput.focus({ preventScroll: true });
            }
        }, 450);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Filter Kategori Portofolio Dark Theme + Proteksi Visibilitas Card
        const filterButtons = document.querySelectorAll('.portfolio-filter-btn');
        const projectCards = document.querySelectorAll('[data-project-card]');
        const emptyNotice = document.getElementById('portfolio-filter-empty');

        const activeBtnClasses = ['border-cyan-400', 'bg-cyan-500/15', 'text-cyan-300'];
        const inactiveBtnClasses = ['border-slate-800', 'bg-[#0E1530]/70', 'text-slate-400', 'hover:border-cyan-400/40', 'hover:text-slate-200'];

        if (filterButtons.length > 0 && projectCards.length > 0) {
            filterButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const selectedCategory = btn.getAttribute('data-filter');

                    filterButtons.forEach(function (otherBtn) {
                        otherBtn.classList.remove(...activeBtnClasses);
                        otherBtn.classList.add(...inactiveBtnClasses);
                    });
                    btn.classList.remove(...inactiveBtnClasses);
                    btn.classList.add(...activeBtnClasses);

                    let visibleCount = 0;
                    projectCards.forEach(function (card) {
                        const cardCategory = card.getAttribute('data-category');
                        const shouldShow = selectedCategory === 'all' || cardCategory === selectedCategory;

                        if (shouldShow) {
                            card.style.setProperty('--reveal-delay', '0ms');
                            card.classList.remove('hidden');
                            card.classList.add('is-visible', 'reveal-done');
                            card.style.willChange = 'auto';
                            visibleCount++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    if (emptyNotice) {
                        if (visibleCount === 0) {
                            emptyNotice.classList.remove('hidden');
                        } else {
                            emptyNotice.classList.add('hidden');
                        }
                    }
                });
            });
        }
    });
</script>

@endsection
