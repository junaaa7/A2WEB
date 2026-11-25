<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 min-h-[42px] bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 hover:brightness-110 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider shadow-[0_0_20px_-5px_rgba(34,211,238,0.4)] focus:outline-none focus:ring-2 focus:ring-cyan-400/50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
