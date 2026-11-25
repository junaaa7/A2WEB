<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 min-h-[42px] bg-[#060919] border border-slate-700 hover:border-cyan-400/50 rounded-xl font-semibold text-xs text-slate-200 hover:text-white uppercase tracking-wider shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-400/40 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
