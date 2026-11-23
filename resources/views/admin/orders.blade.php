<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Leads & Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4">Daftar Prospek Klien</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <th class="p-3 border-b">Tanggal</th>
                                <th class="p-3 border-b">Klien</th>
                                <th class="p-3 border-b">Kontak (WA)</th>
                                <th class="p-3 border-b">Layanan</th>
                                <th class="p-3 border-b">Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 text-sm">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="p-3 font-medium">{{ $order->name }}</td>
                                    <td class="p-3">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank" class="text-green-600 hover:underline">
                                            {{ $order->phone }}
                                        </a>
                                    </td>
                                    <td class="p-3">
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $order->service_category }}</span>
                                        <p class="text-xs text-gray-500 mt-1 truncate max-w-xs">{{ $order->description }}</p>
                                    </td>
                                    <td class="p-3 text-sm text-red-600 font-medium">{{ $order->deadline_date->format('d M Y') }}</td>
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