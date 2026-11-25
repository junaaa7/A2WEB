<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 group']) }}>
    <img src="{{ asset('apple-touch-icon.png') }}?v={{ @filemtime(public_path('apple-touch-icon.png')) ?: 2 }}"
         alt="Logo A2 WEB"
         class="w-9 h-9 rounded-full object-cover ring-1 ring-cyan-400/50 shadow-[0_0_12px_rgba(34,211,238,0.25)] group-hover:ring-cyan-300 transition-all">
    <span class="font-tech-display text-xl sm:text-2xl font-bold tracking-tight text-[#F8FAFC]">
        A2<span class="text-cyan-400">Web</span>
    </span>
</span>