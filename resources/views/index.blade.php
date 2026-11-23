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
<section id="portfolio" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Project Showcase</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Kumpulan karya terbaik yang pernah kami kerjakan, mulai dari sistem manajemen perusahaan hingga pendampingan skripsi IT.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($projects as $project)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-xl transition overflow-hidden flex flex-col">
                    <!-- Image Placeholder / Real Image -->
                    <div class="h-48 bg-gray-200 w-full relative flex items-center justify-center">
                        @if($project->image_path)
                            <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                            <div class="hidden flex items-center justify-center w-full h-full text-gray-400">No Image</div>
                        @else
                            <div class="flex items-center justify-center w-full h-full text-gray-400">No Image</div>
                        @endif
                        <span class="absolute top-4 right-4 bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $project->category }}
                        </span>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-600 mb-4 text-sm line-clamp-3">{{ $project->description }}</p>
                        
                        <div class="mt-auto">
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if(is_array($project->tech_stack))
                                    @foreach($project->tech_stack as $tech)
                                        <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $tech }}</span>
                                    @endforeach
                                @endif
                            </div>
                            @if($project->url_link)
                                <a href="{{ $project->url_link }}" target="_blank" class="text-blue-600 font-medium hover:underline text-sm">
                                    Lihat Proyek &rarr;
                                </a>
                            @endif
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

<!-- 4. FORM PEMESANAN -->
<section id="kontak" class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-50 rounded-2xl p-8 md:p-12 shadow-inner border border-gray-100">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Mulai Proyek Anda!</h2>
                <p class="text-gray-600">Isi form di bawah, sistem akan secara otomatis menghubungkan Anda ke WhatsApp Admin dengan ringkasan pesanan.</p>
            </div>

            <form action="{{ route('order.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Layanan</label>
                        <select name="service_category" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border bg-white">
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <option value="Web UMKM / Profil Bisnis">Web UMKM / Profil Bisnis</option>
                            <option value="Web Sistem / E-Commerce">Web Sistem / E-Commerce</option>
                            <option value="Joki / Pendampingan Skripsi IT">Joki / Pendampingan Skripsi IT</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deadline / Target Selesai</label>
                        <input type="date" name="deadline_date" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kebutuhan / Judul Skripsi</label>
                    <textarea name="description" rows="4" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border placeholder-gray-400" placeholder="Ceritakan detail proyek atau permasalahan yang ingin diselesaikan..."></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                    Kirim Pesanan ke WhatsApp Admin
                </button>
            </form>
        </div>
    </div>
</section>

@endsection