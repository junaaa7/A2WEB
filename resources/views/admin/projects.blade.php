<x-app-layout>
    <x-slot name="header">
        <h2 class="font-tech-display font-bold text-xl text-[#F8FAFC] leading-tight">
            {{ __('Kelola Portofolio') }}
        </h2>
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
                    <div class="font-bold mb-1">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Daftar Data Portofolio -->
            <div class="bg-transparent border-0 p-0 shadow-none md:bg-[#0E1530] md:border md:border-slate-800 md:shadow-xl md:rounded-xl md:p-6 overflow-hidden">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                    <h3 class="font-tech-display text-lg font-bold text-[#F8FAFC]">Daftar Portofolio</h3>
                    <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center justify-center text-center gap-1.5 w-full sm:w-auto min-h-[44px] sm:min-h-[42px] bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 hover:brightness-110 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-[0_0_20px_-5px_rgba(34,211,238,0.4)] transition">
                        + Tambah Portofolio Baru
                    </a>
                </div>

                <!-- Mobile Card View (< md) -->
                <div class="block md:hidden space-y-3">
                    @forelse($projects as $project)
                        @php
                            $allImgs = $project->all_images;
                            $count = count($allImgs);
                            $firstImgUrl = $project->first_image_url;
                        @endphp
                        <div class="bg-[#0E1530] border border-slate-800 rounded-xl p-4 space-y-3 shadow-lg">
                            <!-- Atas: Thumbnail + Judul + Kategori -->
                            <div class="flex items-start gap-3">
                                <div class="relative flex-shrink-0">
                                    @if($firstImgUrl)
                                        <img src="{{ $firstImgUrl }}" alt="{{ $project->title }}" class="w-20 h-16 object-cover rounded-lg border border-slate-700/80 bg-[#060919]">
                                        @if($count > 1)
                                            <span class="absolute -bottom-1 -right-1 bg-cyan-500/90 text-[#060919] text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow">
                                                {{ $count }} Foto
                                            </span>
                                        @endif
                                    @else
                                        <div class="w-20 h-16 rounded-lg bg-[#060919] border border-slate-800 flex items-center justify-center text-[11px] text-slate-500 italic">
                                            No image
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1 space-y-1.5">
                                    <h4 class="font-tech-display text-base font-bold text-[#F8FAFC] leading-snug break-words">{{ $project->title }}</h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-cyan-500/10 text-cyan-300 border border-cyan-400/20">
                                        {{ $project->category }}
                                    </span>
                                </div>
                            </div>

                            <!-- Tengah: Tech Stack -->
                            @if(is_array($project->tech_stack) && count($project->tech_stack) > 0)
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($project->tech_stack as $tech)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs bg-[#060919] border border-slate-800 text-slate-300 break-words">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Bawah: Tombol Aksi Thumb-Friendly -->
                            <div class="grid grid-cols-2 gap-2.5 pt-2 border-t border-slate-800/80">
                                <a href="{{ route('admin.projects.edit', $project->id) }}"
                                   class="inline-flex items-center justify-center min-h-[42px] px-3 py-2 rounded-xl bg-cyan-500/10 hover:bg-cyan-500/20 border border-cyan-400/30 text-cyan-300 text-sm font-semibold transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus portofolio ini beserta seluruh fotonya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full inline-flex items-center justify-center min-h-[42px] px-3 py-2 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-300 text-sm font-semibold transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-[#0E1530] border border-slate-800 rounded-xl p-6 text-center text-[#94A3B8] text-sm">
                            Belum ada portofolio yang ditambahkan.
                        </div>
                    @endforelse
                </div>

                <!-- Desktop Table View (>= md) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0A1026] text-slate-400 uppercase text-xs tracking-wider border-b border-slate-800">
                                <th class="px-3 py-3 sm:p-3.5 whitespace-nowrap">Gambar</th>
                                <th class="px-3 py-3 sm:p-3.5">Judul</th>
                                <th class="px-3 py-3 sm:p-3.5 whitespace-nowrap">Kategori</th>
                                <th class="px-3 py-3 sm:p-3.5">Tech Stack</th>
                                <th class="px-3 py-3 sm:p-3.5 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                @php
                                    $allImgs = $project->all_images;
                                    $count = count($allImgs);
                                    $firstImgUrl = $project->first_image_url;
                                @endphp
                                <tr class="border-b border-slate-800/70 hover:bg-cyan-500/5 transition">
                                    <td class="px-3 py-3 sm:p-3.5 whitespace-nowrap">
                                        @if($firstImgUrl)
                                            <div class="relative inline-block">
                                                <img src="{{ $firstImgUrl }}" alt="{{ $project->title }}" class="w-16 h-12 object-cover rounded-lg border border-slate-700/80 bg-[#060919]">
                                                @if($count > 1)
                                                    <span class="absolute -bottom-1 -right-1 bg-cyan-500/90 text-[#060919] text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow">
                                                        {{ $count }} Foto
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="inline-block px-2.5 py-1.5 rounded-lg bg-[#060919] border border-slate-800 text-xs text-slate-500 italic">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 sm:p-3.5 font-medium text-[#F8FAFC] min-w-[140px]">{{ $project->title }}</td>
                                    <td class="px-3 py-3 sm:p-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-cyan-500/10 text-cyan-300 border border-cyan-400/20">
                                            {{ $project->category }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 sm:p-3.5 min-w-[140px]">
                                        @if(is_array($project->tech_stack))
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($project->tech_stack as $tech)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs bg-[#060919] border border-slate-800 text-slate-300">{{ $tech }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 sm:p-3.5 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-cyan-400 hover:text-cyan-300 font-semibold text-sm hover:underline inline-flex items-center min-h-[36px] sm:min-h-0 px-1 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus portofolio ini beserta seluruh fotonya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-400 hover:text-rose-300 font-semibold text-sm hover:underline inline-flex items-center min-h-[36px] sm:min-h-0 px-1 transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-[#94A3B8]">Belum ada portofolio yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
