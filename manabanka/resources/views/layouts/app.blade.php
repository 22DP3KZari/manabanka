<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 min-h-screen text-white antialiased overflow-x-hidden">
        <div class="min-h-screen relative overflow-x-hidden">
            @include('layouts.navigation')

            <!-- Page Content: pt accounts for nav; main-safe-pt adds safe-area on notched phones -->
            <main class="pb-8 pt-[72px] sm:pt-20 main-safe-pt">
                @yield('content')
            </main>
        </div>
        <style>
            @supports (padding-top: env(safe-area-inset-top)) {
                .main-safe-pt { padding-top: max(72px, calc(72px + env(safe-area-inset-top))); }
                .nav-safe-top > div { padding-top: max(0.75rem, env(safe-area-inset-top)); }
            }
        </style>
        @stack('scripts')
    </body>
</html> 