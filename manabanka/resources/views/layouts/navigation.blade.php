<!-- Minimal floating navigation -->
<div class="absolute top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 pt-6">
        <div class="flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-white">manaBanka</a>
            <div class="flex items-center space-x-6">
                <!-- Navigation Links (Desktop) -->
                <div class="hidden sm:flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-white' : '' }}">
                        {{ __('common.nav_dashboard') }}
                    </a>
                    <a href="{{ route('budget-planner.index') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium {{ request()->routeIs('budget-planner.index') ? 'text-white' : '' }}">
                        {{ __('common.nav_budgets') }}
                    </a>
                    <a href="{{ route('budgets.index') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium {{ request()->routeIs('budgets.index') ? 'text-white' : '' }}">
                        {{ __('common.nav_my_budgets') }}
                    </a>
                    <a href="{{ route('lessons.index') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium {{ request()->routeIs('lessons.*') ? 'text-white' : '' }}">
                        {{ __('common.lessons') }}
                    </a>
                </div>

                <!-- Language Selector -->
                <div class="relative">
                    <button id="navLanguageToggle" class="flex items-center space-x-1 text-gray-400 hover:text-white transition-colors text-sm font-medium focus:outline-none">
                        <span>{{ app()->getLocale() === 'lv' ? __('common.latvian') : __('common.english') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="navLanguageDropdown" class="absolute top-full right-0 mt-1 hidden">
                        <div class="bg-slate-800/95 backdrop-blur-sm border border-slate-700 rounded-lg shadow-lg overflow-hidden min-w-[160px]">
                            <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white transition-colors {{ app()->getLocale() === 'en' ? 'bg-slate-700 text-white' : '' }}">
                                {{ __('common.english') }}
                            </a>
                            <a href="{{ route('lang.switch', 'lv') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white transition-colors {{ app()->getLocale() === 'lv' ? 'bg-slate-700 text-white' : '' }}">
                                {{ __('common.latvian') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Info & Logout (Desktop) -->
                <div class="hidden sm:flex items-center space-x-4">
                    <div class="text-right">
                        <div class="text-sm font-medium text-white">{{ Auth::user()->full_name }}</div>
                        <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">
                            {{ __('common.logout') }}
                        </button>
                    </form>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuToggle" class="sm:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white focus:outline-none transition-colors">
                    <svg id="menuIcon" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="menuClose" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Navigation Menu -->
<div id="mobileMenu" class="sm:hidden fixed inset-0 z-40 bg-slate-900/95 backdrop-blur-sm hidden">
    <div class="h-full flex flex-col">
        <!-- Mobile Menu Header -->
        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-slate-700/50">
            <span class="text-xl font-bold text-white">manaBanka</span>
            <button id="mobileMenuClose" class="p-2 text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Content -->
        <div class="flex-1 overflow-y-auto px-6 py-6">
            <div class="space-y-1 mb-6">
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('dashboard') ? 'text-white bg-slate-800/50' : 'text-gray-400 hover:text-white hover:bg-slate-800/30' }}">
                    {{ __('common.nav_dashboard') }}
                </a>
                <a href="{{ route('budget-planner.index') }}" class="block px-4 py-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('budget-planner.index') ? 'text-white bg-slate-800/50' : 'text-gray-400 hover:text-white hover:bg-slate-800/30' }}">
                    {{ __('common.nav_budgets') }}
                </a>
                <a href="{{ route('budgets.index') }}" class="block px-4 py-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('budgets.index') ? 'text-white bg-slate-800/50' : 'text-gray-400 hover:text-white hover:bg-slate-800/30' }}">
                    {{ __('common.nav_my_budgets') }}
                </a>
                <a href="{{ route('lessons.index') }}" class="block px-4 py-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('lessons.*') ? 'text-white bg-slate-800/50' : 'text-gray-400 hover:text-white hover:bg-slate-800/30' }}">
                    {{ __('common.lessons') }}
                </a>
            </div>
            
            <!-- User Info Section -->
            <div class="pt-6 border-t border-slate-700/50 mb-6">
                <div class="px-4">
                    <div class="text-sm font-medium text-white mb-1">{{ Auth::user()->full_name }}</div>
                    <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>
            
            <!-- Logout -->
            <div class="pt-6 border-t border-slate-700/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-3 text-base font-medium text-gray-400 hover:text-white transition-colors rounded-lg hover:bg-slate-800/30">
                        {{ __('common.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Navigation language dropdown toggle and mobile menu
    document.addEventListener('DOMContentLoaded', function() {
        const navLanguageToggle = document.getElementById('navLanguageToggle');
        const navLanguageDropdown = document.getElementById('navLanguageDropdown');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuOpen = document.getElementById('menuOpen');
        const menuClose = document.getElementById('menuClose');

        // Language dropdown toggle
        if (navLanguageToggle && navLanguageDropdown) {
            navLanguageToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                navLanguageDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking on language links
            navLanguageDropdown.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' || e.target.closest('a')) {
                    navLanguageDropdown.classList.add('hidden');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!navLanguageToggle.contains(e.target) && !navLanguageDropdown.contains(e.target)) {
                    navLanguageDropdown.classList.add('hidden');
                }
            });
        }

        // Mobile menu toggle
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        if (mobileMenuToggle && mobileMenu && menuOpen && menuClose) {
            function openMobileMenu() {
                mobileMenu.classList.remove('hidden');
                menuOpen.classList.add('hidden');
                menuClose.classList.remove('hidden');
            }

            function closeMobileMenu() {
                mobileMenu.classList.add('hidden');
                menuOpen.classList.remove('hidden');
                menuClose.classList.add('hidden');
            }

            mobileMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                openMobileMenu();
            });

            if (mobileMenuClose) {
                mobileMenuClose.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeMobileMenu();
                });
            }

            // Close mobile menu when clicking on a link
            mobileMenu.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' || e.target.closest('a') || (e.target.tagName === 'BUTTON' && e.target.type === 'submit')) {
                    closeMobileMenu();
                }
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileMenuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                    closeMobileMenu();
                }
            });
        }
    });
</script>
