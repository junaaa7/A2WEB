<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Card Portofolio -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5 sm:p-6 flex items-center gap-4 border-l-4 border-blue-500">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase">Total Portofolio</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $projectCount }}</p>
                    </div>
                    <div class="text-blue-500 flex-shrink-0">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>

                <!-- Card Leads / Pesanan -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5 sm:p-6 flex items-center gap-4 border-l-4 border-green-500">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase">Pesanan / Leads Masuk</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $orderCount }}</p>
                    </div>
                    <div class="text-green-500 flex-shrink-0">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>