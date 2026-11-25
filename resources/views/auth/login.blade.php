<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex flex-wrap items-center justify-between gap-2 mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer min-h-[36px]">
                <input id="remember_me" type="checkbox" class="rounded bg-[#060919] border-slate-700 text-cyan-500 shadow-sm focus:ring-cyan-400/30" name="remember">
                <span class="ms-2 text-sm text-[#94A3B8]">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-[#94A3B8] hover:text-cyan-300 rounded-md py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 transition" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="mt-5">
            <x-primary-button class="w-full min-h-[44px]">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
