<x-guest-layout>
    <div class="space-y-6 text-center">
        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Hanhan</p>
        <div class="space-y-2">
            <h1 class="text-2xl font-semibold text-slate-900">Welcome back</h1>
            <p class="text-sm text-slate-500">Sign in to manage rooms, approve bookings, and keep schedules aligned.</p>
        </div>
    </div>

    <div class="mt-8 rounded-2xl border border-slate-200/70 bg-slate-50/60 px-6 py-6 shadow-inner">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')" class="text-slate-600" />
                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus-within:border-slate-400">
                    <x-text-input id="email" class="block w-full border-0 p-0 text-slate-900 placeholder:text-slate-400 focus:ring-0"
                                  type="email" name="email" :value="old('email')" placeholder="you@hanhan.edu" required autofocus autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="text-xs text-red-500" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Password')" class="text-slate-600" />
                    @if (Route::has('password.request'))
                        <a class="text-xs font-medium text-slate-500 hover:text-slate-900" href="{{ route('password.request') }}">
                            {{ __('Forgot?') }}
                        </a>
                    @endif
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus-within:border-slate-400">
                    <x-text-input id="password" class="block w-full border-0 p-0 text-slate-900 placeholder:text-slate-400 focus:ring-0"
                                  type="password"
                                  name="password"
                                  placeholder="••••••••"
                                  required autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="text-xs text-red-500" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="inline-flex items-center gap-2 text-slate-600">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-slate-900 shadow-sm focus:ring-slate-400" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">
                        {{ __('Need an account?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="mt-3 w-full justify-center rounded-2xl bg-slate-900 py-3 text-base font-semibold tracking-tight hover:bg-slate-800">
                {{ __('Log in') }}
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
