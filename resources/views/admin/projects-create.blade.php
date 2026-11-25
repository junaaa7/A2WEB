<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="font-tech-display font-bold text-xl text-[#F8FAFC] leading-tight">
                {{ __('Tambah Portofolio Baru') }}
            </h2>
            <a href="{{ route('admin.projects.index') }}" class="text-sm text-cyan-400 hover:text-cyan-300 hover:underline font-medium inline-flex items-center gap-1 min-h-[36px] sm:min-h-0 transition">
                &larr; Kembali ke Daftar Portofolio
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 px-4 py-3 rounded-xl relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Notifikasi Error Validasi -->
            @if ($errors->any())
                <div class="bg-rose-500/10 border border-rose-500/30 text-rose-300 px-4 py-3 rounded-xl relative" role="alert">
                    <div class="font-bold mb-1">Gagal menyimpan portofolio:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Tambah Portofolio Baru -->
            <div class="bg-[#0E1530] border border-slate-800 shadow-xl rounded-xl p-4 sm:p-6 overflow-hidden">
                <h3 class="font-tech-display text-lg font-bold text-[#F8FAFC] mb-5">Informasi Portofolio Baru</h3>
                <form action="{{ route('admin.projects.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-4"
                      x-data="projectUploadHandler()"
                      @submit="syncBeforeSubmit($event)">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Judul Proyek</label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="w-full min-h-[44px] text-base sm:text-sm bg-[#060919] border border-slate-700 text-slate-100 placeholder-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Kategori</label>
                            <select name="category" required class="w-full min-h-[44px] text-base sm:text-sm bg-[#060919] border border-slate-700 text-slate-100 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl">
                                <option class="bg-[#0B1126] text-slate-100" value="E-Commerce" {{ old('category') === 'E-Commerce' ? 'selected' : '' }}>E-Commerce</option>
                                <option class="bg-[#0B1126] text-slate-100" value="Sistem Manajemen" {{ old('category') === 'Sistem Manajemen' ? 'selected' : '' }}>Sistem Manajemen</option>
                                <option class="bg-[#0B1126] text-slate-100" value="Mobile Apps" {{ old('category') === 'Mobile Apps' ? 'selected' : '' }}>Mobile Apps</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Tech Stack (Pisahkan dengan koma)</label>
                            <input type="text" name="tech_stack" value="{{ old('tech_stack') }}" placeholder="Laravel, Vue, MySQL" required class="w-full min-h-[44px] text-base sm:text-sm bg-[#060919] border border-slate-700 text-slate-100 placeholder-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">URL / Link Demo (Opsional)</label>
                            <input type="url" name="url_link" value="{{ old('url_link') }}" placeholder="https://contoh-proyek.com" class="w-full min-h-[44px] text-base sm:text-sm bg-[#060919] border border-slate-700 text-slate-100 placeholder-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl">
                        </div>

                        <!-- Dropzone Bulk Upload Gambar -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
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
                                class="border-2 border-dashed rounded-xl p-4 sm:p-6 text-center cursor-pointer transition-all duration-200 select-none"
                                :class="isDragging
                                    ? 'border-cyan-400 bg-cyan-500/10 ring-4 ring-cyan-400/15 scale-[1.01]'
                                    : 'border-slate-700 hover:border-cyan-400/60 bg-[#060919]/70 hover:bg-[#0A1026]/80'"
                            >
                                <div class="flex flex-col items-center justify-center pointer-events-none">
                                    <div class="w-11 h-11 sm:w-12 sm:h-12 mb-3 rounded-full flex items-center justify-center transition"
                                         :class="isDragging ? 'bg-cyan-500 text-[#060919]' : 'bg-cyan-500/10 text-cyan-400 border border-cyan-400/25'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <p class="text-xs sm:text-sm font-semibold text-slate-200 leading-relaxed">
                                        <span class="text-cyan-400 hover:underline">Ketuk untuk pilih banyak gambar dari galeri</span>, atau drag &amp; drop di desktop
                                    </p>
                                    <p class="text-xs text-[#94A3B8] mt-1">
                                        Bisa pilih banyak gambar sekaligus. JPG, PNG, WEBP, GIF hingga 5MB per file.
                                    </p>
                                </div>
                            </div>

                            <!-- Pesan Peringatan Validasi Frontend -->
                            <div x-show="errorMessage" class="mt-2.5 p-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs flex items-center justify-between gap-2" x-cloak>
                                <div class="flex items-center gap-2 min-w-0">
                                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span class="break-words" x-text="errorMessage"></span>
                                </div>
                                <button type="button" @click="errorMessage = ''" class="text-amber-300 hover:text-amber-100 font-bold p-1 min-w-[32px] min-h-[32px] flex items-center justify-center text-sm flex-shrink-0">&times;</button>
                            </div>

                            <!-- Bar Ringkasan & Kosongkan Pilihan -->
                            <div x-show="fileList.length > 0" class="mt-4 flex flex-wrap items-center justify-between gap-2 bg-cyan-500/10 border border-cyan-400/25 px-3.5 py-2.5 rounded-xl" x-cloak>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-5 h-5 bg-cyan-500 text-[#060919] text-xs font-bold rounded-full flex-shrink-0" x-text="fileList.length"></span>
                                    <span class="text-xs font-semibold text-cyan-200">
                                        <span x-text="fileList.length + ' gambar dipilih'"></span>
                                        <span class="text-cyan-400 font-normal hidden sm:inline">&bull; Gambar pertama (#1) otomatis menjadi Cover Utama</span>
                                    </span>
                                </div>
                                <button type="button" @click="clearAll()" class="text-xs text-rose-400 hover:text-rose-300 font-medium hover:underline flex items-center gap-1 py-1 min-h-[32px] transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Kosongkan Pilihan</span>
                                </button>
                            </div>

                            <!-- Grid Preview Gambar -->
                            <div x-show="fileList.length > 0" class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3" x-cloak>
                                <template x-for="(item, idx) in fileList" :key="item.id">
                                    <div class="relative group rounded-xl overflow-hidden border border-slate-700/80 bg-[#0A1026] shadow-sm flex flex-col hover:border-cyan-400/50 transition">
                                        <div class="aspect-video w-full relative bg-[#060919] flex items-center justify-center overflow-hidden">
                                            <img :src="item.url" :alt="item.name" class="w-full h-full object-cover">
                                            <span x-show="idx === 0" class="absolute top-1.5 left-1.5 bg-cyan-500 text-[#060919] text-[10px] font-bold px-2 py-0.5 rounded shadow">
                                                Cover
                                            </span>
                                            <button type="button" @click="removeFile(idx)" class="opacity-100 absolute top-1.5 right-1.5 bg-rose-600 hover:bg-rose-500 text-white rounded-full w-8 h-8 sm:w-7 sm:h-7 flex items-center justify-center transition shadow focus:outline-none" title="Batalkan foto ini" aria-label="Batalkan foto ini">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-2 flex flex-col border-t border-slate-800/80">
                                            <span class="text-xs font-medium text-slate-200 truncate" :title="item.name" x-text="item.name"></span>
                                            <span class="text-[10px] text-[#94A3B8] font-mono" x-text="item.size"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Deskripsi</label>
                            <textarea name="description" rows="4" required class="w-full text-base sm:text-sm bg-[#060919] border border-slate-700 text-slate-100 placeholder-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 rounded-xl">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <button type="submit" class="w-full sm:w-auto min-h-[46px] inline-flex items-center justify-center bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 hover:brightness-110 text-white font-semibold px-5 py-2.5 rounded-xl transition shadow-[0_0_20px_-5px_rgba(34,211,238,0.4)]">
                            Simpan Portofolio
                        </button>
                        <a href="{{ route('admin.projects.index') }}" class="w-full sm:w-auto min-h-[44px] inline-flex items-center justify-center bg-[#060919] sm:bg-transparent border border-slate-700 hover:border-slate-500 text-slate-300 hover:text-white px-4 py-2 text-sm font-medium rounded-xl transition">
                            Batal
                        </a>
                    </div>
                </form>
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
                            id: `${file.name}-${file.size}-${file.lastModified}`,
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
                    if (!input) {
                        return;
                    }

                    const dt = new DataTransfer();
                    this.fileList.forEach(item => {
                        dt.items.add(item.file);
                    });
                    input.files = dt.files;
                },

                syncBeforeSubmit() {
                    this.syncInput();
                },

                formatSize(bytes) {
                    if (bytes < 1024) {
                        return bytes + ' B';
                    }
                    if (bytes < 1024 * 1024) {
                        return (bytes / 1024).toFixed(1) + ' KB';
                    }
                    return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
                }
            };
        }
    </script>
</x-app-layout>
