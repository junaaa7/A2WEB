@extends('layouts.front')

@section('content')

<!-- 1. HERO SECTION -->
<section id="hero" class="pt-28 pb-20 lg:pt-36 lg:pb-28 bg-gradient-to-br from-blue-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
            Solusi Cerdas Pembuatan Website Profesional & Pendampingan Sistem Skripsi
        </h1>
        <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-3xl mx-auto">
            Membantu UMKM go-digital dengan website modern dan membimbing mahasiswa Informatika meraih gelar sarjana dengan sistem skripsi berkualitas.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
            <a href="#kontak" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 shadow-lg transition">
                Konsultasi Gratis
            </a>
            <a href="#portfolio" class="bg-white text-blue-600 border border-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition">
                Lihat Karya Kami
            </a>
        </div>
        
        <!-- Tech Stack Icons (Text/Badge Base) -->
        <div class="mt-10 border-t border-gray-200 pt-8">
            <p class="text-sm text-gray-500 mb-4 font-medium uppercase tracking-wider">Teknologi yang Kami Gunakan</p>
            <div class="flex flex-wrap justify-center gap-4 text-gray-500 font-medium">
                <span class="bg-gray-100 px-4 py-2 rounded-full">Laravel 13</span>
                <span class="bg-gray-100 px-4 py-2 rounded-full">PHP 8.5</span>
                <span class="bg-gray-100 px-4 py-2 rounded-full">Tailwind CSS</span>
                <span class="bg-gray-100 px-4 py-2 rounded-full">MySQL</span>
            </div>
        </div>
    </div>
</section>

<!-- 2. PORTOFOLIO SECTION -->
<section id="portfolio" class="py-20 bg-white"
    x-data="{
        isOpen: false,
        activeProject: null,
        currentImageIndex: 0,
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
        }
    }"
    @keydown.escape.window="closeModal()"
    @keydown.arrow-right.window="if (isOpen) nextImage()"
    @keydown.arrow-left.window="if (isOpen) prevImage()"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Project Showcase</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Kumpulan karya terbaik yang pernah kami kerjakan, mulai dari sistem manajemen perusahaan hingga pendampingan skripsi IT.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
                <div @click="openModal(@js($projectData))"
                     class="group bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden flex flex-col">
                    <!-- Image Placeholder / Real Image -->
                    <div class="h-48 bg-gray-200 w-full relative flex items-center justify-center overflow-hidden">
                        @if($firstImageUrl)
                            <img src="{{ $firstImageUrl }}" 
                                 alt="{{ $project->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                 onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                            <div class="hidden flex items-center justify-center w-full h-full text-gray-400">No Image</div>
                        @else
                            <div class="flex items-center justify-center w-full h-full text-gray-400">No Image</div>
                        @endif

                        <!-- Category Badge -->
                        <span class="absolute top-4 right-4 bg-blue-100/90 backdrop-blur-sm text-blue-800 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                            {{ $project->category }}
                        </span>

                        <!-- Badge Jumlah Foto jika lebih dari 1 -->
                        @if($imageCount > 1)
                            <span class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-md text-white text-[11px] font-semibold px-2 py-0.5 rounded-md shadow-sm flex items-center gap-1 border border-white/20">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $imageCount }} Foto</span>
                            </span>
                        @endif
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-600 mb-4 text-sm line-clamp-3 leading-relaxed">{{ $project->description }}</p>
                        
                        <div class="mt-auto">
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @if(is_array($project->tech_stack))
                                    @foreach($project->tech_stack as $tech)
                                        <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $tech }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-sm">
                                <span class="text-xs text-blue-600 font-semibold group-hover:underline flex items-center gap-1">
                                    <span>Detail Proyek</span>
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                                @if($project->url_link)
                                    <a href="{{ $project->url_link }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       @click.stop 
                                       onclick="event.stopPropagation()"
                                       class="inline-flex items-center gap-1 text-gray-500 hover:text-blue-600 font-medium text-xs hover:underline transition">
                                        <span>Lihat Proyek</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 text-gray-500">
                    Belum ada portofolio yang ditambahkan.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Pop-up Detail Proyek & Galeri Slider -->
    <div 
        x-show="isOpen" 
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6 lg:p-8"
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
            class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden relative border border-gray-100"
            @click.stop
        >
            <!-- Modal Header (Sticky) -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white/95 backdrop-blur-sm sticky top-0 z-10">
                <div class="flex items-center gap-2">
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full" x-text="activeProject?.category"></span>
                    <span class="text-xs text-gray-400 font-medium hidden sm:inline">&bull; Detail Showcase</span>
                </div>
                <button 
                    type="button" 
                    @click="closeModal()" 
                    class="text-gray-400 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition focus:outline-none"
                    aria-label="Tutup Modal"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div class="overflow-y-auto p-6 space-y-6">
                <!-- Area Galeri / Image Slider Interaktif -->
                <div class="space-y-3">
                    <!-- Tampilan Gambar Utama -->
                    <div class="w-full rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 relative flex items-center justify-center min-h-[220px] select-none">
                        <!-- Jika Ada Gambar -->
                        <template x-if="activeProject?.images && activeProject.images.length > 0">
                            <div class="w-full relative flex items-center justify-center">
                                <img 
                                    :src="activeProject.images[currentImageIndex]" 
                                    :alt="activeProject.title" 
                                    class="w-full max-h-[55vh] object-contain rounded-xl bg-gray-100 transition-opacity duration-200"
                                >

                                <!-- Indikator Nomor Foto (jika > 1 gambar) -->
                                <template x-if="activeProject.images.length > 1">
                                    <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-xs font-semibold px-2.5 py-1 rounded-full shadow border border-white/10">
                                        <span x-text="(currentImageIndex + 1) + ' / ' + activeProject.images.length"></span>
                                    </div>
                                </template>

                                <!-- Tombol Navigasi Sebelumnya (<) -->
                                <template x-if="activeProject.images.length > 1">
                                    <button 
                                        type="button" 
                                        @click.stop="prevImage()" 
                                        class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/75 text-white p-2.5 rounded-full transition shadow-lg backdrop-blur-sm focus:outline-none"
                                        aria-label="Foto Sebelumnya"
                                        title="Foto Sebelumnya (Panah Kiri)"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                </template>

                                <!-- Tombol Navigasi Berikutnya (>) -->
                                <template x-if="activeProject.images.length > 1">
                                    <button 
                                        type="button" 
                                        @click.stop="nextImage()" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/75 text-white p-2.5 rounded-full transition shadow-lg backdrop-blur-sm focus:outline-none"
                                        aria-label="Foto Berikutnya"
                                        title="Foto Berikutnya (Panah Kanan)"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </template>
                            </div>
                        </template>

                        <!-- Placeholder jika tidak ada gambar -->
                        <template x-if="!activeProject?.images || activeProject.images.length === 0">
                            <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                                <svg class="w-16 h-16 mb-2 stroke-current opacity-40" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium">Tidak ada screenshot yang diunggah</span>
                            </div>
                        </template>
                    </div>

                    <!-- Deretan Thumbnail Kecil yang Dapat Diklik (jika > 1 gambar) -->
                    <template x-if="activeProject?.images && activeProject.images.length > 1">
                        <div class="flex items-center gap-2 overflow-x-auto pb-1 pt-1">
                            <template x-for="(img, idx) in activeProject.images" :key="idx">
                                <button 
                                    type="button" 
                                    @click="setCurrentImage(idx)" 
                                    class="relative flex-shrink-0 w-20 h-14 rounded-lg overflow-hidden border-2 transition-all cursor-pointer focus:outline-none"
                                    :class="currentImageIndex === idx ? 'border-blue-600 ring-2 ring-blue-500/30 scale-105' : 'border-transparent opacity-60 hover:opacity-100 hover:border-gray-300'"
                                    :title="'Buka foto ke-' + (idx + 1)"
                                >
                                    <img :src="img" :alt="'Thumbnail ' + (idx + 1)" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Judul & Kategori -->
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3" x-text="activeProject?.title"></h3>
                    
                    <!-- Seluruh Tag Tech Stack -->
                    <div class="flex flex-wrap gap-2 pt-1">
                        <template x-for="(tech, index) in (activeProject?.tech_stack || [])" :key="index">
                            <span class="text-xs bg-blue-50 text-blue-700 font-medium px-3 py-1 rounded-md border border-blue-100" x-text="tech"></span>
                        </template>
                    </div>
                </div>

                <!-- Deskripsi Lengkap (whitespace-pre-line) -->
                <div class="border-t border-gray-100 pt-5">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">Deskripsi Lengkap</h4>
                    <p class="text-gray-700 text-sm sm:text-base leading-relaxed whitespace-pre-line" x-text="activeProject?.description"></p>
                </div>
            </div>

            <!-- Modal Footer (Action Buttons) -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div>
                    <template x-if="activeProject?.url_link">
                        <a 
                            :href="activeProject.url_link" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-blue-700 transition shadow-sm w-full sm:w-auto justify-center"
                        >
                            <span>Kunjungi Proyek / Live Demo</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </template>
                </div>
                
                <button 
                    type="button" 
                    @click="closeModal()" 
                    class="w-full sm:w-auto px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition text-center"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</section>

<!-- 3. LAYANAN & HARGA SECTION -->
<section id="layanan" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Layanan & Harga</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Pilih paket layanan yang paling sesuai dengan kebutuhan bisnis atau studi Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Paket 1 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:border-blue-500 transition relative">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Web UMKM / Profil Bisnis</h3>
                <p class="text-gray-500 text-sm mb-6">Cocok untuk memperluas jangkauan digital bisnis Anda.</p>
                <div class="mb-6"><span class="text-3xl font-extrabold text-gray-900">Mulai Rp 1,5 Jt</span></div>
                <ul class="space-y-3 mb-8 text-gray-600 text-sm">
                    <li class="flex items-center">✅ Desain Responsif & Modern</li>
                    <li class="flex items-center">✅ Domain & Hosting 1 Tahun</li>
                    <li class="flex items-center">✅ Integrasi WhatsApp & Maps</li>
                    <li class="flex items-center">✅ Basic SEO Optimization</li>
                </ul>
            </div>

            <!-- Paket 2 -->
            <div class="bg-blue-600 rounded-2xl shadow-xl p-8 transform md:-translate-y-4 relative text-white">
                <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-bl-lg rounded-tr-lg uppercase">Populer</div>
                <h3 class="text-xl font-bold mb-2">Web Sistem / E-Commerce</h3>
                <p class="text-blue-100 text-sm mb-6">Solusi custom untuk operasional dan penjualan online.</p>
                <div class="mb-6"><span class="text-3xl font-extrabold">Mulai Rp 4 Jt</span></div>
                <ul class="space-y-3 mb-8 text-blue-50 text-sm">
                    <li class="flex items-center">✅ Fitur Custom Sesuai Request</li>
                    <li class="flex items-center">✅ Database & Arsitektur Solid</li>
                    <li class="flex items-center">✅ Payment Gateway Integration</li>
                    <li class="flex items-center">✅ Dashboard Admin & Laporan</li>
                </ul>
            </div>

            <!-- Paket 3 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:border-blue-500 transition relative">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Joki / Skripsi IT</h3>
                <p class="text-gray-500 text-sm mb-6">Pendampingan penuh dari perancangan hingga sidang.</p>
                <div class="mb-6"><span class="text-3xl font-extrabold text-gray-900">Mulai Rp 2,5 Jt</span></div>
                <ul class="space-y-3 mb-8 text-gray-600 text-sm">
                    <li class="flex items-center">✅ Pembuatan Aplikasi/Sistem</li>
                    <li class="flex items-center">✅ Bebas Revisi Mayor (S&K)</li>
                    <li class="flex items-center">✅ Bimbingan Source Code</li>
                    <li class="flex items-center">✅ Dokumentasi UML & Flowchart</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- 4. FAQ SECTION -->
<section id="faq" class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider bg-blue-50 px-3 py-1 rounded-full">FAQ</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 mb-4">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Masih ada keraguan? Berikut beberapa pertanyaan umum seputar layanan pembuatan website dan pendampingan skripsi IT kami.</p>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            <!-- FAQ 1 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden transition-all bg-white" :class="active === 1 ? 'border-blue-500 shadow-sm' : 'hover:border-gray-300'">
                <button 
                    type="button" 
                    @click="active = (active === 1 ? null : 1)" 
                    class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none transition-colors"
                    :class="active === 1 ? 'bg-blue-50/40 text-blue-900' : 'text-gray-900'"
                >
                    <span class="font-semibold text-base md:text-lg">Berapa lama estimasi pengerjaan website atau sistem skripsi?</span>
                    <span class="ml-4 flex-shrink-0 text-blue-600 transition-transform duration-200" :class="active === 1 ? 'rotate-180' : ''">
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
                    class="px-6 pb-5 pt-1 text-gray-600 text-sm md:text-base leading-relaxed border-t border-gray-100"
                >
                    Waktu pengerjaan tergantung pada paket yang dipilih:
                    <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                        <li><strong>Web UMKM / Profil Bisnis:</strong> 3 &ndash; 7 hari kerja.</li>
                        <li><strong>Web Sistem / E-Commerce:</strong> 2 &ndash; 4 minggu (tergantung kompleksitas fitur).</li>
                        <li><strong>Pendampingan Skripsi IT:</strong> Fleksibel menyesuaikan jadwal bimbingan/sidang Anda, umumnya 1 &ndash; 3 minggu.</li>
                    </ul>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden transition-all bg-white" :class="active === 2 ? 'border-blue-500 shadow-sm' : 'hover:border-gray-300'">
                <button 
                    type="button" 
                    @click="active = (active === 2 ? null : 2)" 
                    class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none transition-colors"
                    :class="active === 2 ? 'bg-blue-50/40 text-blue-900' : 'text-gray-900'"
                >
                    <span class="font-semibold text-base md:text-lg">Apakah saya akan mendapatkan 100% source code dan database?</span>
                    <span class="ml-4 flex-shrink-0 text-blue-600 transition-transform duration-200" :class="active === 2 ? 'rotate-180' : ''">
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
                    class="px-6 pb-5 pt-1 text-gray-600 text-sm md:text-base leading-relaxed border-t border-gray-100"
                >
                    Tentu saja! Setelah pelunasan, seluruh <strong>source code</strong>, <strong>file database (.sql)</strong>, dan aset pendukung akan diserahkan secara lengkap tanpa enkripsi atau batasan. Anda memiliki hak milik penuh atas aplikasi tersebut.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden transition-all bg-white" :class="active === 3 ? 'border-blue-500 shadow-sm' : 'hover:border-gray-300'">
                <button 
                    type="button" 
                    @click="active = (active === 3 ? null : 3)" 
                    class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none transition-colors"
                    :class="active === 3 ? 'bg-blue-50/40 text-blue-900' : 'text-gray-900'"
                >
                    <span class="font-semibold text-base md:text-lg">Bagaimana alur dan sistem pembayarannya?</span>
                    <span class="ml-4 flex-shrink-0 text-blue-600 transition-transform duration-200" :class="active === 3 ? 'rotate-180' : ''">
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
                    class="px-6 pb-5 pt-1 text-gray-600 text-sm md:text-base leading-relaxed border-t border-gray-100"
                >
                    Sistem pembayaran dirancang aman dan transparan:
                    <ol class="list-decimal list-inside mt-2 space-y-1 text-gray-600">
                        <li><strong>Konsultasi & Kesepakatan:</strong> Diskusi kebutuhan fitur dan penentuan estimasi harga.</li>
                        <li><strong>Down Payment (DP):</strong> Pembayaran uang muka sebesar 30% &ndash; 50% untuk mulai pengerjaan.</li>
                        <li><strong>Progress & Demo:</strong> Kami mendemokan aplikasi yang sudah berjalan via live server atau video call.</li>
                        <li><strong>Pelunasan & Serah Terima:</strong> Pelunasan sisa tagihan, dilanjutkan serah terima source code dan bimbingan setup.</li>
                    </ol>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden transition-all bg-white" :class="active === 4 ? 'border-blue-500 shadow-sm' : 'hover:border-gray-300'">
                <button 
                    type="button" 
                    @click="active = (active === 4 ? null : 4)" 
                    class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none transition-colors"
                    :class="active === 4 ? 'bg-blue-50/40 text-blue-900' : 'text-gray-900'"
                >
                    <span class="font-semibold text-base md:text-lg">Untuk pendampingan skripsi IT, apa saja yang saya dapatkan?</span>
                    <span class="ml-4 flex-shrink-0 text-blue-600 transition-transform duration-200" :class="active === 4 ? 'rotate-180' : ''">
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
                    class="px-6 pb-5 pt-1 text-gray-600 text-sm md:text-base leading-relaxed border-t border-gray-100"
                >
                    Anda mendapatkan pendampingan menyeluruh dari perancangan hingga dinyatakan lulus sidang:
                    <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                        <li>Aplikasi siap pakai sesuai metode & algoritma skripsi (misal: SPK AHP/TOPSIS/SAW, Machine Learning, GIS, dll).</li>
                        <li>Diagram UML (Use Case, Activity, Sequence, Class Diagram) & ERD Database.</li>
                        <li>Sesi bedah koding (1-on-1 penjelasan alur program agar percaya diri menghadapi pertanyaan penguji).</li>
                        <li>Garansi revisi dari dosen pembimbing maupun penguji.</li>
                    </ul>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden transition-all bg-white" :class="active === 5 ? 'border-blue-500 shadow-sm' : 'hover:border-gray-300'">
                <button 
                    type="button" 
                    @click="active = (active === 5 ? null : 5)" 
                    class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none transition-colors"
                    :class="active === 5 ? 'bg-blue-50/40 text-blue-900' : 'text-gray-900'"
                >
                    <span class="font-semibold text-base md:text-lg">Apakah ada garansi jika terjadi error atau bug setelah serah terima?</span>
                    <span class="ml-4 flex-shrink-0 text-blue-600 transition-transform duration-200" :class="active === 5 ? 'rotate-180' : ''">
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
                    class="px-6 pb-5 pt-1 text-gray-600 text-sm md:text-base leading-relaxed border-t border-gray-100"
                >
                    Ada! Kami memberikan <strong>garansi perbaikan bug/error gratis selama 30 hari</strong> setelah proyek diserahkan. Jika ada kendala teknis atau fungsi yang tidak berjalan sesuai kesepakatan awal, kami akan segera memperbaikinya tanpa biaya tambahan.
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden transition-all bg-white" :class="active === 6 ? 'border-blue-500 shadow-sm' : 'hover:border-gray-300'">
                <button 
                    type="button" 
                    @click="active = (active === 6 ? null : 6)" 
                    class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none transition-colors"
                    :class="active === 6 ? 'bg-blue-50/40 text-blue-900' : 'text-gray-900'"
                >
                    <span class="font-semibold text-base md:text-lg">Bagaimana cara memulai konsultasi dan pemesanan?</span>
                    <span class="ml-4 flex-shrink-0 text-blue-600 transition-transform duration-200" :class="active === 6 ? 'rotate-180' : ''">
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
                    class="px-6 pb-5 pt-1 text-gray-600 text-sm md:text-base leading-relaxed border-t border-gray-100"
                >
                    Sangat mudah! Anda cukup mengisi formulir pemesanan di bawah ini atau klik tombol <strong>"Konsultasi Gratis"</strong> di bagian atas untuk langsung tersambung ke WhatsApp Admin. Konsultasi awal 100% gratis tanpa komitmen.
                </div>
            </div>
        </div>

        <!-- Call to Action Card -->
        <div class="mt-12 text-center bg-blue-50 rounded-2xl p-6 md:p-8 border border-blue-100">
            <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Masih memiliki pertanyaan lain?</h3>
            <p class="text-gray-600 text-sm md:text-base mb-6">Jangan ragu untuk berdiskusi dengan tim kami tentang kebutuhan ide sistem atau aplikasi Anda.</p>
            <a href="#kontak" class="inline-flex items-center justify-center bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 transition shadow-md">
                Tanya Langsung ke Kami &rarr;
            </a>
        </div>
    </div>
</section>

<!-- 5. FORM PEMESANAN -->
<section id="kontak" class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl p-8 md:p-12 shadow-sm border border-gray-100">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Mulai Proyek Anda!</h2>
                <p class="text-gray-600">Isi form di bawah, sistem akan secara otomatis menghubungkan Anda ke WhatsApp Admin dengan ringkasan pesanan.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada isian Anda:</h3>
                            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('order.store') }}" method="POST" class="space-y-6"
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

                            // Otomatis ubah tanggal deadline ke batas minimal layanan yang dipilih
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
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Layanan</label>
                        <select name="service_category" required x-model="service" @change="updateDeadline()" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border bg-white">
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <option value="Web UMKM / Profil Bisnis">Web UMKM / Profil Bisnis (Min. 7 hari)</option>
                            <option value="Web Sistem / E-Commerce">Web Sistem / E-Commerce (Min. 4 minggu)</option>
                            <option value="Joki / Pendampingan Skripsi IT">Joki / Pendampingan Skripsi IT (Min. 3 minggu)</option>
                        </select>
                        @error('service_category')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deadline / Target Selesai</label>
                        <input type="date" name="deadline_date" required x-model="deadline" :min="minDate" :disabled="!service"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border transition-colors"
                            :class="!service ? 'bg-gray-100 cursor-not-allowed text-gray-400' : 'bg-white text-gray-900'">
                        
                        <!-- Info Estimasi Realtime -->
                        <div class="mt-1.5" x-show="service" x-cloak>
                            <p class="text-xs text-blue-700 flex items-center gap-1 font-medium bg-blue-50 px-2.5 py-1 rounded-md border border-blue-200">
                                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><span x-text="infoText"></span> &bull; paling cepat tgl <strong x-text="formattedMinDate"></strong></span>
                            </p>
                        </div>
                        <div class="mt-1.5" x-show="!service">
                            <p class="text-xs text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Pilih layanan di samping terlebih dahulu untuk membuka pilihan tanggal.</span>
                            </p>
                        </div>
                        @error('deadline_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kebutuhan / Judul Skripsi</label>
                    <textarea name="description" rows="4" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border placeholder-gray-400" placeholder="Ceritakan detail proyek atau permasalahan yang ingin diselesaikan...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                    Kirim Pesanan ke WhatsApp Admin
                </button>
            </form>
        </div>
    </div>
</section>

@endsection