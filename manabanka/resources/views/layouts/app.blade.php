<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 min-h-screen text-white antialiased">
        <div class="min-h-screen relative">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="pb-8 pt-20">
                @yield('content')
            </main>
        </div>
        @stack('scripts')
    </body>
</html> 