<x-app-layout>
    <x-slot name="header">
        <h2 class="font-tech-display font-bold text-xl text-[#F8FAFC] leading-tight">
            {{ __('Data Leads & Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-transparent border-0 p-0 shadow-none md:bg-[#0E1530] md:border md:border-slate-800 md:shadow-xl md:rounded-xl md:p-6 overflow-hidden">

                <h3 class="font-tech-display text-lg font-bold text-[#F8FAFC] mb-4">Daftar Prospek Klien</h3>

                <!-- Mobile Card View (< md) -->
                <div class="block md:hidden space-y-3">
                    @forelse($orders as $order)
                        <div class="bg-[#0E1530] border border-slate-800 rounded-xl p-4 space-y-3 shadow-lg">
                            <!-- Header Kartu: Nama Klien & Tanggal -->
                            <div class="flex items-start justify-between gap-3">
                                <h4 class="font-tech-display text-base font-bold text-[#F8FAFC] break-words min-w-0">{{ $order->name }}</h4>
                                <span class="text-xs text-[#94A3B8] whitespace-nowrap flex-shrink-0 pt-0.5">{{ $order->created_at->format('d M Y') }}</span>
                            </div>

                            <!-- Badge Layanan & Deadline -->
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-block bg-cyan-500/10 text-cyan-300 border border-cyan-400/20 text-xs font-medium px-2.5 py-1 rounded-full">{{ $order->service_category }}</span>
                                <span class="inline-flex items-center text-xs font-medium text-rose-400 bg-rose-500/10 border border-rose-500/20 px-2.5 py-1 rounded-full">
                                    Deadline: {{ $order->deadline_date->format('d M Y') }}
                                </span>
                            </div>

                            <!-- Deskripsi Kebutuhan Utuh -->
                            <p class="text-sm text-slate-300 whitespace-pre-line break-words leading-relaxed bg-[#060919]/60 border border-slate-800/80 rounded-lg p-3">{{ $order->description }}</p>

                            <!-- Tombol WhatsApp Full Width -->
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-full min-h-[44px] inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500/15 hover:bg-emerald-500/25 border border-emerald-500/35 text-emerald-300 hover:text-emerald-200 text-sm font-semibold transition">
                                <span>Hubungi via WhatsApp ({{ $order->phone }})</span>
                            </a>
                        </div>
                    @empty
                        <div class="bg-[#0E1530] border border-slate-800 rounded-xl p-6 text-center text-[#94A3B8] text-sm">
                            Belum ada pesanan masuk.
                        </div>
                    @endforelse
                </div>

                <!-- Desktop Table View (>= md) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0A1026] text-slate-400 uppercase text-xs tracking-wider border-b border-slate-800">
                                <th class="px-3 py-3 sm:p-3.5 whitespace-nowrap">Tanggal</th>
                                <th class="px-3 py-3 sm:p-3.5 whitespace-nowrap">Klien</th>
                                <th class="px-3 py-3 sm:p-3.5 whitespace-nowrap">Kontak (WA)</th>
                                <th class="px-3 py-3 sm:p-3.5">Layanan</th>
                                <th class="px-3 py-3 sm:p-3.5 whitespace-nowrap">Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="border-b border-slate-800/70 hover:bg-cyan-500/5 transition">
                                    <td class="px-3 py-3 sm:p-3.5 text-sm text-slate-300 whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-3 py-3 sm:p-3.5 font-medium text-[#F8FAFC] whitespace-nowrap">{{ $order->name }}</td>
                                    <td class="px-3 py-3 sm:p-3.5 whitespace-nowrap">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank" rel="noopener noreferrer" class="text-emerald-400 hover:text-emerald-300 font-medium hover:underline inline-flex items-center py-1 min-h-[36px] sm:min-h-0 transition">
                                            {{ $order->phone }}
                                        </a>
                                    </td>
                                    <td class="px-3 py-3 sm:p-3.5 min-w-[200px]">
                                        <span class="inline-block bg-cyan-500/10 text-cyan-300 border border-cyan-400/20 text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap">{{ $order->service_category }}</span>
                                        <p class="text-xs text-[#94A3B8] mt-1.5 truncate max-w-[200px] sm:max-w-xs">{{ $order->description }}</p>
                                    </td>
                                    <td class="px-3 py-3 sm:p-3.5 text-sm text-rose-400 font-medium whitespace-nowrap">{{ $order->deadline_date->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-[#94A3B8]">Belum ada pesanan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>