<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A2WEB | Jasa Pembuatan Website & Skripsi IT</title>
    <!-- Favicon transparan / tanpa logo -->
    <link rel="icon" type="image/png" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">
    <!-- Memuat Tailwind CSS melalui Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <!-- Navbar Sederhana -->
    <nav class="fixed w-full bg-white shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="#" class="text-2xl font-bold text-blue-600">A2Web</a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#hero" class="text-gray-600 hover:text-blue-600 transition">Beranda</a>
                    <a href="#portfolio" class="text-gray-600 hover:text-blue-600 transition">Portofolio</a>
                    <a href="#layanan" class="text-gray-600 hover:text-blue-600 transition">Layanan</a>
                    <a href="#faq" class="text-gray-600 hover:text-blue-600 transition">FAQ</a>
                </div>
                <div>
                    <a href="#kontak" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} Porto Juns Web. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>