<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hanhan · Room Booking</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-900"></div>
            <div class="absolute inset-x-0 top-0 -z-10 h-[40rem] bg-[radial-gradient(circle_600px_at_top,_rgba(56,189,248,0.3),_transparent)]"></div>

            <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-12 sm:py-16 lg:px-8">
                <header class="flex items-center justify-between text-white">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 backdrop-blur">
                            <x-application-logo class="h-7 w-7 text-white" />
                        </span>
                        <div>
                            <p class="text-lg font-semibold">Hanhan</p>
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-300">Room booking</p>
                        </div>
                    </div>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-3 text-sm font-medium">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-full px-5 py-2 text-white/80 hover:text-white">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-full px-5 py-2 text-white/80 hover:text-white">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-full border border-white/30 bg-white/10 px-5 py-2 text-white shadow-lg shadow-cyan-500/20 transition hover:bg-white/20">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </header>

                <main class="grid flex-1 items-center gap-12 py-12 lg:grid-cols-[1.1fr,0.9fr]">
                    <div class="space-y-8 text-white">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-white/70">
                            Effortless coordination
                        </span>
                        <div class="space-y-6">
                            <h1 class="text-4xl font-semibold leading-tight sm:text-5xl lg:text-6xl">
                                Book university rooms in seconds with a calm, minimal dashboard.
                            </h1>
                            <p class="text-base text-white/80 sm:text-lg">
                                Hanhan keeps your campus spaces perfectly organized. Track availability, manage bookings, and keep every meeting on schedule without juggling spreadsheets.
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-base font-semibold text-slate-900 shadow-lg shadow-slate-900/30 transition hover:-translate-y-0.5">
                                        Go to dashboard
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-base font-semibold text-slate-900 shadow-lg shadow-slate-900/30 transition hover:-translate-y-0.5">
                                        Create free account
                                    </a>
                                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-white/30 px-6 py-3 text-base font-semibold text-white/80 transition hover:border-white hover:text-white">
                                        Sign in
                                    </a>
                                @endauth
                            @endif
                        </div>
                        <div class="grid gap-6 text-sm text-white/70 sm:grid-cols-3">
                            <div>
                                <p class="text-3xl font-semibold text-white">12+</p>
                                <p>Rooms managed daily</p>
                            </div>
                            <div>
                                <p class="text-3xl font-semibold text-white">2 min</p>
                                <p>Average booking time</p>
                            </div>
                            <div>
                                <p class="text-3xl font-semibold text-white">100%</p>
                                <p>Visibility across spaces</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -inset-6 rounded-[2.5rem] bg-white/10 blur-3xl"></div>
                        <div class="relative rounded-[2.5rem] border border-white/15 bg-white/5 p-8 shadow-2xl ring-1 ring-white/10 backdrop-blur">
                            <div class="rounded-[1.75rem] border border-white/15 bg-slate-900/80 p-6 shadow-xl">
                                <div class="flex items-center justify-between text-xs text-white/60">
                                    <span>Today</span>
                                    <span>Hanhan Rooms</span>
                                </div>
                                <div class="mt-6 space-y-4">
                                    @foreach (['Innovation Lab','Seminar Room 2A','Library Think Space'] as $room)
                                        <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                            <div>
                                                <p class="text-sm font-semibold text-white">{{ $room }}</p>
                                                <p class="text-xs text-white/60">08:00 – 10:00</p>
                                            </div>
                                            <span class="rounded-full bg-white/10 px-3 py-1 text-xs text-white/70">Reserved</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-8 rounded-2xl border border-white/10 bg-gradient-to-r from-cyan-400/20 to-indigo-400/20 px-4 py-5 text-white">
                                    <p class="text-sm font-semibold">Instant status updates</p>
                                    <p class="text-xs text-white/70">Subscribers get alerts the moment slots open up.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="flex flex-wrap items-center justify-between gap-4 border-t border-white/10 pt-6 text-white/60 text-sm">
                    <span>© {{ now()->year }} Hanhan · Minimal room booking</span>
                    <span>Designed for calm campus coordination</span>
                </footer>
            </div>
        </div>
    </body>
</html>
