<x-app-layout>
    <x-slot name="header">
        <h2 class="font-tech-display font-bold text-xl text-[#F8FAFC] leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#0E1530] border border-slate-800 overflow-hidden shadow-xl rounded-xl">
                <div class="p-6 text-slate-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
