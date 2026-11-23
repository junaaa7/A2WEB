<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Portofolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form Tambah Portofolio -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Tambah Portofolio Baru</h3>
                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Proyek</label>
                            <input type="text" name="title" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="E-Commerce">E-Commerce</option>
                                <option value="Sistem Manajemen">Sistem Manajemen</option>
                                <option value="Mobile Apps">Mobile Apps</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tech Stack (Pisahkan dengan koma)</label>
                            <input type="text" name="tech_stack" placeholder="Laravel, Vue, MySQL" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">URL / Link Demo (Opsional)</label>
                            <input type="url" name="url_link" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Upload Gambar Screenshot</label>
                            <input type="file" name="image" accept="image/*" class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" rows="3" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan Portofolio</button>
                    </div>
                </form>
            </div>

            <!-- Tabel Data Portofolio -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Portofolio</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <th class="p-3 border-b">Gambar</th>
                                <th class="p-3 border-b">Judul</th>
                                <th class="p-3 border-b">Kategori</th>
                                <th class="p-3 border-b">Tech Stack</th>
                                <th class="p-3 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">
                                        @if($project->image_path)
                                            <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->title }}" class="w-16 h-12 object-cover rounded shadow-sm">
                                        @else
                                            <span class="text-xs text-gray-400 italic">No image</span>
                                        @endif
                                    </td>
                                    <td class="p-3 font-medium">{{ $project->title }}</td>
                                    <td class="p-3">{{ $project->category }}</td>
                                    <td class="p-3">
                                        @if(is_array($project->tech_stack))
                                            {{ implode(', ', $project->tech_stack) }}
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>