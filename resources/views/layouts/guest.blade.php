<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-gradient-to-br from-neutral-950 via-purple-950/40 to-black text-white antialiased min-h-screen">
        <div class="min-h-screen flex items-center justify-center px-4 py-10">
            <div class="w-full max-w-4xl grid md:grid-cols-2 gap-8 items-center">
                <div class="space-y-4">
                    <a href="/" class="inline-flex items-center gap-2 text-purple-300 font-semibold">
                        <span class="w-3 h-3 rounded-full bg-purple-400 animate-pulse"></span>
                        Cloud Music
                    </a>
                    <h1 class="text-4xl font-bold leading-tight">Temukan, putar, dan unggah musik favoritmu.</h1>
                    <p class="text-neutral-400 text-sm md:text-base">Login atau daftar untuk menyimpan playlist, upload lagu, dan dengarkan rekomendasi yang dipersonalisasi.</p>
                    <div class="flex items-center gap-3 text-xs text-neutral-500">
                        <span class="px-3 py-1 rounded-full border border-neutral-800 bg-neutral-900/60">Tanpa iklan</span>
                        <span class="px-3 py-1 rounded-full border border-neutral-800 bg-neutral-900/60">Streaming cepat</span>
                        <span class="px-3 py-1 rounded-full border border-neutral-800 bg-neutral-900/60">Upload MP3</span>
                    </div>
                </div>

                <div class="bg-neutral-900/70 border border-neutral-800 backdrop-blur-lg rounded-2xl shadow-2xl p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
