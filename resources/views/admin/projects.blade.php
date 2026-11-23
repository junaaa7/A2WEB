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

            <!-- Notifikasi Error Validasi -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <div class="font-bold mb-1">Gagal menyimpan portofolio:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Tambah Portofolio -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Tambah Portofolio Baru</h3>
                <form action="{{ route('admin.projects.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="space-y-4"
                      x-data="projectUploadHandler()"
                      @submit="syncBeforeSubmit($event)">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Proyek</label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="E-Commerce" {{ old('category') === 'E-Commerce' ? 'selected' : '' }}>E-Commerce</option>
                                <option value="Sistem Manajemen" {{ old('category') === 'Sistem Manajemen' ? 'selected' : '' }}>Sistem Manajemen</option>
                                <option value="Mobile Apps" {{ old('category') === 'Mobile Apps' ? 'selected' : '' }}>Mobile Apps</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tech Stack (Pisahkan dengan koma)</label>
                            <input type="text" name="tech_stack" value="{{ old('tech_stack') }}" placeholder="Laravel, Vue, MySQL" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">URL / Link Demo (Opsional)</label>
                            <input type="url" name="url_link" value="{{ old('url_link') }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <!-- Dropzone Bulk Upload Gambar -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Upload Gambar Screenshot (Bulk Upload / Banyak Gambar Sekaligus)
                            </label>

                            <!-- Hidden native file input khusus picker (TANPA atribut name, aman di-reset) -->
                            <input type="file" 
                                   x-ref="pickerInput" 
                                   multiple 
                                   accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" 
                                   @change="handlePickerSelect($event)"
                                   class="hidden">

                            <!-- Hidden native file input resmi untuk submit form (MEMILIKI name="images[]" dan multiple) -->
                            <input type="file" 
                                   x-ref="formFileInput" 
                                   name="images[]" 
                                   multiple 
                                   accept="image/*" 
                                   class="hidden">

                            <!-- Area Dropzone Interaktif -->
                            <div 
                                @click="$refs.pickerInput.click()"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                class="border-2 border-dashed rounded-xl p-6 text-center cursor-pointer transition-all duration-200 select-none"
                                :class="isDragging 
                                    ? 'border-blue-500 bg-blue-50/70 ring-4 ring-blue-500/20 scale-[1.01]' 
                                    : 'border-gray-300 hover:border-blue-400 bg-gray-50/60 hover:bg-gray-50'"
                            >
                                <div class="flex flex-col items-center justify-center pointer-events-none">
                                    <div class="w-12 h-12 mb-3 rounded-full flex items-center justify-center transition"
                                         :class="isDragging ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        <span class="text-blue-600 hover:underline">Klik untuk memilih banyak gambar</span> atau seret & lepas (Drag & Drop) ke sini
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Bisa pilih banyak gambar sekaligus (Ctrl + Klik / Blok file). JPG, PNG, WEBP, GIF hingga 5MB per file.
                                    </p>
                                </div>
                            </div>

                            <!-- Pesan Peringatan Validasi Frontend -->
                            <div x-show="errorMessage" class="mt-2.5 p-3 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-center justify-between" x-cloak>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span x-text="errorMessage"></span>
                                </div>
                                <button type="button" @click="errorMessage = ''" class="text-amber-600 hover:text-amber-800 font-bold ml-2 text-sm">&times;</button>
                            </div>

                            <!-- Bar Ringkasan & Kosongkan Pilihan -->
                            <div x-show="fileList.length > 0" class="mt-4 flex items-center justify-between bg-blue-50/70 border border-blue-200 px-3.5 py-2 rounded-lg" x-cloak>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-5 h-5 bg-blue-600 text-white text-xs font-bold rounded-full" x-text="fileList.length"></span>
                                    <span class="text-xs font-semibold text-blue-900">
                                        <span x-text="fileList.length + ' gambar dipilih'"></span>
                                        <span class="text-blue-600 font-normal hidden sm:inline">&bull; Gambar pertama (#1) otomatis menjadi Cover Utama</span>
                                    </span>
                                </div>
                                <button type="button" @click="clearAll()" class="text-xs text-red-600 hover:text-red-800 font-medium hover:underline flex items-center gap-1 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Kosongkan Pilihan</span>
                                </button>
                            </div>

                            <!-- Grid Preview Gambar -->
                            <div x-show="fileList.length > 0" class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3" x-cloak>
                                <template x-for="(item, idx) in fileList" :key="idx">
                                    <div class="relative group rounded-xl overflow-hidden border border-gray-200 bg-white shadow-sm flex flex-col hover:border-blue-300 transition">
                                        <div class="aspect-video w-full relative bg-gray-100 flex items-center justify-center overflow-hidden">
                                            <img :src="item.url" :alt="item.name" class="w-full h-full object-cover">
                                            <span x-show="idx === 0" class="absolute top-1.5 left-1.5 bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow">
                                                Cover
                                            </span>
                                            <button type="button" @click="removeFile(idx)" class="absolute top-1.5 right-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 transition shadow focus:outline-none" title="Batalkan foto ini">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-2 flex flex-col">
                                            <span class="text-xs font-medium text-gray-800 truncate" :title="item.name" x-text="item.name"></span>
                                            <span class="text-[10px] text-gray-400 font-mono" x-text="item.size"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
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
                                @php
                                    $allImgs = $project->all_images;
                                    $count = count($allImgs);
                                    $firstImgUrl = $project->first_image_url;
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">
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
                                    <td class="p-3 font-medium">{{ $project->title }}</td>
                                    <td class="p-3">{{ $project->category }}</td>
                                    <td class="p-3">
                                        @if(is_array($project->tech_stack))
                                            {{ implode(', ', $project->tech_stack) }}
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-sm hover:underline">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus portofolio ini beserta seluruh fotonya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Pengelola Bulk Upload DataTransfer & Preview -->
    <script>
        function projectUploadHandler() {
            return {
                fileList: [],
                isDragging: false,
                errorMessage: '',
                maxFiles: 15,
                maxSize: 5 * 1024 * 1024, // 5MB per file

                handlePickerSelect(e) {
                    const incoming = e.target.files;
                    if (incoming && incoming.length) {
                        this.addFiles(incoming);
                    }
                    // Reset input picker agar memilih file yang sama bisa memicu event change lagi
                    e.target.value = '';
                },

                handleDrop(e) {
                    this.isDragging = false;
                    const incoming = e.dataTransfer.files;
                    if (incoming && incoming.length) {
                        this.addFiles(incoming);
                    }
                },

                addFiles(files) {
                    this.errorMessage = '';
                    let rejected = [];

                    Array.from(files).forEach(file => {
                        if (!file.type.match(/^image\//i)) {
                            rejected.push(`${file.name} (bukan file gambar)`);
                            return;
                        }

                        if (file.size > this.maxSize) {
                            rejected.push(`${file.name} (> 5MB)`);
                            return;
                        }

                        const isDuplicate = this.fileList.some(item => 
                            item.file.name === file.name && 
                            item.file.size === file.size && 
                            item.file.lastModified === file.lastModified
                        );

                        if (isDuplicate) {
                            return;
                        }

                        if (this.fileList.length >= this.maxFiles) {
                            rejected.push(`${file.name} (maksimal ${this.maxFiles} gambar)`);
                            return;
                        }

                        this.fileList.push({
                            file: file,
                            name: file.name,
                            size: this.formatSize(file.size),
                            url: URL.createObjectURL(file)
                        });
                    });

                    if (rejected.length > 0) {
                        this.errorMessage = 'Beberapa file dilewati: ' + rejected.join(', ');
                    }

                    this.syncInput();
                },

                removeFile(index) {
                    if (this.fileList[index]) {
                        URL.revokeObjectURL(this.fileList[index].url);
                        this.fileList.splice(index, 1);
                        this.syncInput();
                    }
                },

                clearAll() {
                    this.fileList.forEach(item => URL.revokeObjectURL(item.url));
                    this.fileList = [];
                    this.errorMessage = '';
                    this.syncInput();
                },

                syncInput() {
                    const input = this.$refs.formFileInput;
                    if (!input) return;

                    const dt = new DataTransfer();
                    this.fileList.forEach(item => {
                        dt.items.add(item.file);
                    });
                    input.files = dt.files;
                },

                syncBeforeSubmit(e) {
                    this.syncInput();
                },

                formatSize(bytes) {
                    if (bytes < 1024) return bytes + ' B';
                    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                    return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
                }
            };
        }
    </script>
</x-app-layout>