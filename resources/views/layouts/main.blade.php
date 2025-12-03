<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cloud Music' }}</title>
    <script src="https://cdn.tailwindcss.com" data-turbo-track="reload"></script>
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-umd.js" data-turbo-track="reload"></script>
</head>
<body class="bg-neutral-950 text-white antialiased">
    <div class="flex min-h-screen" id="app-shell">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-h-screen">
            <x-layout.topbar />

            <main class="flex-1 px-8 py-6">
                @yield('content')
            </main>
        </div>
    </div>

    <x-player.bar />

    <script src="{{ asset('js/player.js') }}"></script>
    @stack('scripts')
</body>
</html>
