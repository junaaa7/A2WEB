<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Leads & Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 sm:p-6">
                
                <h3 class="text-lg font-bold mb-4">Daftar Prospek Klien</h3>
                <div class="overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-xs sm:text-sm">
                                <th class="px-3 py-3 sm:p-3 border-b whitespace-nowrap">Tanggal</th>
                                <th class="px-3 py-3 sm:p-3 border-b whitespace-nowrap">Klien</th>
                                <th class="px-3 py-3 sm:p-3 border-b whitespace-nowrap">Kontak (WA)</th>
                                <th class="px-3 py-3 sm:p-3 border-b">Layanan</th>
                                <th class="px-3 py-3 sm:p-3 border-b whitespace-nowrap">Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-3 py-3 sm:p-3 text-sm whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-3 py-3 sm:p-3 font-medium whitespace-nowrap">{{ $order->name }}</td>
                                    <td class="px-3 py-3 sm:p-3 whitespace-nowrap">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank" class="text-green-600 hover:underline inline-flex items-center py-1 min-h-[36px] sm:min-h-0">
                                            {{ $order->phone }}
                                        </a>
                                    </td>
                                    <td class="px-3 py-3 sm:p-3 min-w-[200px]">
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full whitespace-nowrap">{{ $order->service_category }}</span>
                                        <p class="text-xs text-gray-500 mt-1 truncate max-w-[200px] sm:max-w-xs">{{ $order->description }}</p>
                                    </td>
                                    <td class="px-3 py-3 sm:p-3 text-sm text-red-600 font-medium whitespace-nowrap">{{ $order->deadline_date->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-500">Belum ada pesanan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>