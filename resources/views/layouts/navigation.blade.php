<nav x-data="{ open: false }" class="sticky top-0 z-20 border-b border-transparent bg-transparent">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-4">
        <div class="rounded-3xl border border-slate-200/70 bg-white/80 backdrop-blur shadow-sm px-4 sm:px-6">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-sm font-semibold tracking-tight text-slate-900">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-white">
                                <x-application-logo class="h-6 w-6 fill-current text-white" />
                            </span>
                            <div class="hidden sm:block leading-tight">
                                <span class="block text-base font-semibold">Hanhan</span>
                                <span class="text-xs font-normal uppercase text-slate-500 tracking-[0.25em]">Room booking</span>
                            </div>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-4 text-sm font-medium sm:flex">
                        @auth
                            @if (Auth::user()->role === 'mahasiswa')
                                <x-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')" class="px-3 py-2 rounded-full">
                                    {{ __('Rooms') }}
                                </x-nav-link>
                                <x-nav-link :href="route('my-bookings.index')" :active="request()->routeIs('my-bookings.index')" class="px-3 py-2 rounded-full">
                                    {{ __('My Bookings') }}
                                </x-nav-link>
                            @elseif (Auth::user()->role === 'admin')
                                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="px-3 py-2 rounded-full">
                                    {{ __('Admin Dashboard') }}
                                </x-nav-link>
                                <x-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.index')" class="px-3 py-2 rounded-full">
                                    {{ __('Manage Rooms') }}
                                </x-nav-link>
                                <x-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.index')" class="px-3 py-2 rounded-full">
                                    {{ __('Manage Bookings') }}
                                </x-nav-link>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <div class="text-right">
                        <p class="text-xs uppercase text-slate-400">Signed in</p>
                        @auth
                            <p class="text-sm font-medium text-slate-700">{{ Auth::user()->name }}</p>
                        @endauth
                    </div>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 rounded-full border border-slate-200/70 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 focus:outline-none transition duration-150">
                                <span>{{ __('Menu') }}</span>
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @auth
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            @endauth
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center rounded-2xl border border-slate-200/80 p-2 text-slate-500 hover:bg-slate-50 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="mx-4 rounded-3xl border border-slate-200/70 bg-white/90 backdrop-blur py-4 shadow-sm space-y-1">
            @auth
                @if (Auth::user()->role === 'mahasiswa')
                    <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')">
                        {{ __('Rooms') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('my-bookings.index')" :active="request()->routeIs('my-bookings.index')">
                        {{ __('My Bookings') }}
                    </x-responsive-nav-link>
                @elseif (Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.index')">
                        {{ __('Manage Rooms') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.index')">
                        {{ __('Manage Bookings') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="mx-4 mt-4 rounded-3xl border border-slate-200/70 bg-white/90 backdrop-blur px-4 py-4 shadow-sm">
            @auth
                <div>
                    <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-4 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>
