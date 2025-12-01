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
    <body class="font-sans text-slate-900 antialiased bg-slate-50">
        <div class="relative min-h-screen flex items-center justify-center px-4">
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-slate-50 via-white to-slate-100"></div>
            <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-[radial-gradient(circle,_rgba(45,212,191,0.25),_transparent_55%)]"></div>

            <div class="w-full max-w-md space-y-8">
                <div class="text-center space-y-4">
                    <a href="/" class="inline-flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-200/70 bg-white/80 backdrop-blur">
                        <x-application-logo class="h-10 w-10 fill-current text-slate-700" />
                    </a>
                    <div>
                        <h1 class="text-2xl font-semibold tracking-tight">Hanhan</h1>
                        <p class="text-sm text-slate-500 uppercase tracking-[0.3em]">Room booking</p>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200/80 bg-white/90 backdrop-blur px-8 py-8 shadow-lg">
                    {{ $slot }}
                </div>

                <p class="text-center text-xs text-slate-400">© {{ now()->year }} Hanhan — Seamless spaces, simple booking.</p>
            </div>
        </div>
    </body>
</html>
