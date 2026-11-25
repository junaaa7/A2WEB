<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 min-h-[42px] bg-rose-600 border border-rose-500/40 rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-rose-500 active:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500/50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
