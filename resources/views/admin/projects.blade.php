<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Portofolio') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Notifikasi Error Validasi -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <div class="font-bold mb-1">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tabel Data Portofolio -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <h3 class="text-lg font-bold">Daftar Portofolio</h3>
                    <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center justify-center gap-1.5 w-full sm:w-auto min-h-[44px] sm:min-h-0 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-md shadow-sm transition">
                        + Tambah Portofolio Baru
                    </a>
                </div>
                <div class="overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-xs sm:text-sm">
                                <th class="px-3 py-3 sm:p-3 border-b whitespace-nowrap">Gambar</th>
                                <th class="px-3 py-3 sm:p-3 border-b">Judul</th>
                                <th class="px-3 py-3 sm:p-3 border-b whitespace-nowrap">Kategori</th>
                                <th class="px-3 py-3 sm:p-3 border-b">Tech Stack</th>
                                <th class="px-3 py-3 sm:p-3 border-b whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                @php
                                    $allImgs = $project->all_images;
                                    $count = count($allImgs);
                                    $firstImgUrl = $project->first_image_url;
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-3 py-3 sm:p-3 whitespace-nowrap">
                                        @if($firstImgUrl)
                                            <div class="relative inline-block">
                                                <img src="{{ $firstImgUrl }}" alt="{{ $project->title }}" class="w-16 h-12 object-cover rounded shadow-sm">
                                                @if($count > 1)
                                                    <span class="absolute -bottom-1 -right-1 bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow">
                                                        {{ $count }} Foto
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 sm:p-3 font-medium min-w-[140px]">{{ $project->title }}</td>
                                    <td class="px-3 py-3 sm:p-3 whitespace-nowrap">{{ $project->category }}</td>
                                    <td class="px-3 py-3 sm:p-3 min-w-[140px]">
                                        @if(is_array($project->tech_stack))
                                            {{ implode(', ', $project->tech_stack) }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 sm:p-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-sm hover:underline inline-flex items-center min-h-[36px] sm:min-h-0 px-1">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus portofolio ini beserta seluruh fotonya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm hover:underline inline-flex items-center min-h-[36px] sm:min-h-0 px-1">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-500">Belum ada portofolio yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
