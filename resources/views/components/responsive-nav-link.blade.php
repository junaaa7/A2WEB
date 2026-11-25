@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center w-full px-4 py-3 min-h-[44px] border-l-4 border-cyan-400 text-start text-base font-medium text-cyan-300 bg-cyan-500/10 focus:outline-none focus:text-cyan-200 focus:bg-cyan-500/15 focus:border-cyan-300 transition duration-150 ease-in-out'
            : 'flex items-center w-full px-4 py-3 min-h-[44px] border-l-4 border-transparent text-start text-base font-medium text-slate-300 hover:text-cyan-300 hover:bg-[#0E1530] hover:border-cyan-400/40 focus:outline-none focus:text-cyan-300 focus:bg-[#0E1530] focus:border-cyan-400/40 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
