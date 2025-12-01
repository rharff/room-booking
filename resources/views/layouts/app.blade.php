<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900">
        <div class="relative min-h-screen flex flex-col">
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-slate-50 via-white to-slate-100"></div>
            <div class="absolute inset-y-0 right-0 -z-10 opacity-40 pointer-events-none">
                <div class="w-72 sm:w-96 h-full translate-x-16 sm:translate-x-24 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.15),_transparent_60%)]"></div>
            </div>

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 mt-8">
                    <div class="rounded-3xl border border-slate-200/80 bg-white/80 backdrop-blur shadow-sm px-6 py-5">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 w-full">
                <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 py-10">
                    <div class="rounded-3xl border border-slate-200/70 bg-white/90 backdrop-blur-sm shadow-sm min-h-[45vh]">
                        {{ $slot }}
                    </div>
                </div>
            </main>

            <footer class="w-full px-6 pb-10 text-sm text-slate-500">
                <div class="mx-auto max-w-6xl flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-slate-200/70 bg-white/90 backdrop-blur px-6 py-4 shadow-sm">
                    <div>
                        <p class="text-base font-semibold text-slate-900">Hanhan · Room Booking</p>
                        <p class="text-sm text-slate-500">Spaces organized, schedules effortless.</p>
                    </div>
                    <span class="text-slate-400">© {{ now()->year }} Hanhan. All rights reserved.</span>
                </div>
            </footer>
        </div>
    </body>
</html>
