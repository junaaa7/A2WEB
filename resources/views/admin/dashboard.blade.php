<x-app-layout>
    <x-slot name="header">
        <h2 class="font-tech-display font-bold text-xl text-[#F8FAFC] leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="sm:py-12">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:py-0 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Card Portofolio -->
                <a href="{{ route('admin.projects.index') }}"
                   class="group bg-[#0E1530] border border-slate-800 hover:border-cyan-400/40 rounded-2xl p-6 transition-all duration-200 flex flex-col justify-between gap-4 border-l-4 border-l-cyan-400 shadow-lg hover:shadow-[0_0_28px_-10px_rgba(34,211,238,0.28)]">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-[#94A3B8] uppercase tracking-wider">Total Portofolio</p>
                            <p class="font-tech-display text-4xl font-bold text-white mt-2">{{ $projectCount }}</p>
                        </div>
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-cyan-500/10 border border-cyan-400/20 text-cyan-400 flex items-center justify-center flex-shrink-0 group-hover:bg-cyan-500/15 transition">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs font-semibold text-cyan-400 group-hover:text-cyan-300">
                        <span>Kelola Portofolio</span>
                        <span class="group-hover:translate-x-0.5 transition-transform" aria-hidden="true">&rarr;</span>
                    </div>
                </a>

                <!-- Card Leads / Pesanan -->
                <a href="{{ route('admin.orders.index') }}"
                   class="group bg-[#0E1530] border border-slate-800 hover:border-purple-400/40 rounded-2xl p-6 transition-all duration-200 flex flex-col justify-between gap-4 border-l-4 border-l-purple-400 shadow-lg hover:shadow-[0_0_28px_-10px_rgba(168,85,247,0.28)]">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-[#94A3B8] uppercase tracking-wider">Pesanan / Leads Masuk</p>
                            <p class="font-tech-display text-4xl font-bold text-white mt-2">{{ $orderCount }}</p>
                        </div>
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-purple-500/10 border border-purple-400/20 text-purple-400 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500/15 transition">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs font-semibold text-purple-400 group-hover:text-purple-300">
                        <span>Kelola Pesanan</span>
                        <span class="group-hover:translate-x-0.5 transition-transform" aria-hidden="true">&rarr;</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>