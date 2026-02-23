<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - manaBanka</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 min-h-screen text-white antialiased">
    <div class="min-h-screen relative overflow-x-hidden">
        <!-- Admin nav -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/90 backdrop-blur-sm border-b border-slate-700/50 safe-area-pad-t">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center min-h-12 sm:min-h-14">
                    <a href="{{ route('admin.dashboard') }}" class="text-base sm:text-xl font-bold text-white shrink-0 truncate max-w-[140px] sm:max-w-none">{{ __('common.admin_brand') }}</a>

                    <!-- Desktop nav links -->
                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700/80 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-800/60' }}">{{ __('common.admin_nav_dashboard') }}</a>
                        <a href="{{ route('admin.users') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.users*') ? 'bg-slate-700/80 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-800/60' }}">{{ __('common.admin_nav_users') }}</a>
                        <a href="{{ route('admin.transactions') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.transactions') ? 'bg-slate-700/80 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-800/60' }}">{{ __('common.admin_nav_transactions') }}</a>
                        <a href="{{ route('admin.lessons.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.lessons*') ? 'bg-slate-700/80 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-800/60' }}">{{ __('common.admin_nav_lesson_translations') }}</a>
                    </div>

                    <!-- Right: Language (desktop), App, user, logout / hamburger (mobile) -->
                    <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                        <!-- Language dropdown (desktop) -->
                        <div class="relative hidden md:block">
                            <button id="adminLangToggle" type="button" class="flex items-center gap-1 text-gray-400 hover:text-white transition-colors text-sm font-medium focus:outline-none rounded-lg px-2 py-1.5 -mr-1">
                                <span>{{ app()->getLocale() === 'lv' ? __('common.latvian') : __('common.english') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div id="adminLangDropdown" class="absolute top-full right-0 mt-1 hidden">
                                <div class="bg-slate-800 border border-slate-700 rounded-lg shadow-xl overflow-hidden min-w-[140px]">
                                    <a href="{{ route('lang.switch', ['locale' => 'en', 'back' => request()->getRequestUri()]) }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 hover:text-white transition-colors {{ app()->getLocale() === 'en' ? 'bg-slate-700 text-white' : '' }}">{{ __('common.english') }}</a>
                                    <a href="{{ route('lang.switch', ['locale' => 'lv', 'back' => request()->getRequestUri()]) }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 hover:text-white transition-colors {{ app()->getLocale() === 'lv' ? 'bg-slate-700 text-white' : '' }}">{{ __('common.latvian') }}</a>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('dashboard') }}" class="hidden md:inline text-sm text-gray-400 hover:text-white transition-colors">{{ __('common.app') }}</a>
                        <span class="hidden md:inline text-sm text-gray-400 truncate max-w-[100px] lg:max-w-[180px]">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="hidden md:inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-400 hover:text-white transition-colors font-medium">{{ __('common.logout') }}</button>
                        </form>

                        <!-- Mobile menu button -->
                        <button id="adminMobileMenuBtn" type="button" class="md:hidden p-2 -mr-2 rounded-lg text-gray-400 hover:text-white hover:bg-slate-800/60 transition-colors" aria-label="Menu">
                            <svg id="adminMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            <svg id="adminMenuClose" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Admin mobile menu overlay: fully opaque, no transparency -->
        <div id="adminMobileMenu" class="md:hidden fixed inset-0 z-40 hidden admin-mobile-menu-bg">
            <div class="h-full flex flex-col pt-[env(safe-area-inset-top)]">
                <div class="flex items-center justify-between px-4 py-4 border-b border-slate-700/50">
                    <span class="text-lg font-bold text-white">{{ __('common.admin') }}</span>
                    <button id="adminMobileMenuClose" type="button" class="p-2 -mr-2 rounded-lg text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto px-4 py-4">
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700/80 text-white' : 'text-gray-400 hover:bg-slate-800/60 hover:text-white' }}">{{ __('common.admin_nav_dashboard') }}</a>
                        <a href="{{ route('admin.users') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('admin.users*') ? 'bg-slate-700/80 text-white' : 'text-gray-400 hover:bg-slate-800/60 hover:text-white' }}">{{ __('common.admin_nav_users') }}</a>
                        <a href="{{ route('admin.transactions') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('admin.transactions') ? 'bg-slate-700/80 text-white' : 'text-gray-400 hover:bg-slate-800/60 hover:text-white' }}">{{ __('common.admin_nav_transactions') }}</a>
                        <a href="{{ route('admin.lessons.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('admin.lessons*') ? 'bg-slate-700/80 text-white' : 'text-gray-400 hover:bg-slate-800/60 hover:text-white' }}">{{ __('common.admin_nav_lesson_translations') }}</a>
                    </nav>
                    <!-- Language (mobile, same as app) -->
                    <div class="mt-6 pb-4 border-b border-slate-700/50">
                        <p class="px-4 text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">{{ __('common.language') }}</p>
                        <a href="{{ route('lang.switch', ['locale' => 'en', 'back' => request()->getRequestUri()]) }}" class="flex items-center min-h-[44px] px-4 py-2 rounded-xl text-base {{ app()->getLocale() === 'en' ? 'text-white bg-slate-700/80' : 'text-gray-400 hover:bg-slate-800/60 hover:text-white' }}">{{ __('common.english') }}</a>
                        <a href="{{ route('lang.switch', ['locale' => 'lv', 'back' => request()->getRequestUri()]) }}" class="flex items-center min-h-[44px] px-4 py-2 rounded-xl text-base {{ app()->getLocale() === 'lv' ? 'text-white bg-slate-700/80' : 'text-gray-400 hover:bg-slate-800/60 hover:text-white' }}">{{ __('common.latvian') }}</a>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-700/50">
                        <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-400 hover:bg-slate-800/60 hover:text-white">{{ __('common.back_to_app') }}</a>
                    </div>
                    <div class="mt-4 px-4 py-2 text-sm text-gray-500">{{ Auth::user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-3 rounded-xl text-base font-medium text-gray-400 hover:bg-slate-800/60 hover:text-white mt-2">{{ __('common.logout') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <main class="pt-14 sm:pt-16 pb-8 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto admin-main-pt">
            @yield('content')
        </main>
    </div>

    <style>
        .admin-mobile-menu-bg { background-color: #0f172a; }
        @supports (padding-top: env(safe-area-inset-top)) {
            .safe-area-pad-t { padding-top: env(safe-area-inset-top); }
            .admin-main-pt { padding-top: max(3.5rem, calc(3.5rem + env(safe-area-inset-top))); }
            @media (min-width: 640px) { .admin-main-pt { padding-top: max(4rem, calc(4rem + env(safe-area-inset-top))); } }
        }
    </style>
    <script>
        (function() {
            // Admin mobile menu
            var btn = document.getElementById('adminMobileMenuBtn');
            var menu = document.getElementById('adminMobileMenu');
            var closeBtn = document.getElementById('adminMobileMenuClose');
            var openIcon = document.getElementById('adminMenuOpen');
            var closeIcon = document.getElementById('adminMenuClose');
            if (btn && menu) {
                function openMenu() {
                    menu.classList.remove('hidden');
                    if (openIcon) openIcon.classList.add('hidden');
                    if (closeIcon) closeIcon.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
                function closeMenu() {
                    menu.classList.add('hidden');
                    if (openIcon) openIcon.classList.remove('hidden');
                    if (closeIcon) closeIcon.classList.add('hidden');
                    document.body.style.overflow = '';
                }
                btn.addEventListener('click', openMenu);
                if (closeBtn) closeBtn.addEventListener('click', closeMenu);
                menu.addEventListener('click', function(e) {
                    if (e.target.closest('a') || (e.target.closest('button') && e.target.closest('form'))) closeMenu();
                });
            }

            // Admin language dropdown (desktop)
            var langToggle = document.getElementById('adminLangToggle');
            var langDropdown = document.getElementById('adminLangDropdown');
            if (langToggle && langDropdown) {
                langToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    langDropdown.classList.toggle('hidden');
                });
                langDropdown.addEventListener('click', function(e) {
                    if (e.target.tagName === 'A' || e.target.closest('a')) langDropdown.classList.add('hidden');
                });
                document.addEventListener('click', function(e) {
                    if (!langToggle.contains(e.target) && !langDropdown.contains(e.target)) langDropdown.classList.add('hidden');
                });
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>
