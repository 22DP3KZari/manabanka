<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to manaBanka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-slate-950 min-h-screen overflow-x-hidden">
    <!-- Minimal floating navigation - mobile-optimized -->
    <div class="fixed top-0 left-0 right-0 z-50 welcome-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
            <div class="flex justify-between items-center gap-2 min-h-[44px]">
                <a href="{{ url('/') }}" class="text-lg sm:text-xl font-bold text-white shrink-0">manaBanka</a>
                <div class="flex items-center gap-2 sm:gap-5 shrink-0">
                    <div class="relative">
                        <button id="languageToggle" type="button" class="flex items-center gap-1 text-gray-400 hover:text-white active:text-white transition-colors text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-revolut-purple/50 rounded-md py-2 pr-1 -mr-1 min-h-[44px] min-w-[44px] justify-end sm:justify-center sm:min-w-0">
                            <span class="sm:hidden font-medium">{{ app()->getLocale() === 'lv' ? 'LV' : 'EN' }}</span>
                            <span class="hidden sm:inline">{{ app()->getLocale() === 'lv' ? __('common.latvian') : __('common.english') }}</span>
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="languageDropdown" class="absolute top-full right-0 mt-1 hidden">
                            <div class="bg-slate-800/95 backdrop-blur-sm border border-slate-700 rounded-lg shadow-xl overflow-hidden min-w-[140px]">
                                <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-3 sm:py-2.5 text-sm text-gray-300 hover:bg-slate-700 hover:text-white active:bg-slate-700 transition-colors {{ app()->getLocale() === 'en' ? 'bg-slate-700 text-white' : '' }}">
                                    {{ __('common.english') }}
                                </a>
                                <a href="{{ route('lang.switch', 'lv') }}" class="block px-4 py-3 sm:py-2.5 text-sm text-gray-300 hover:bg-slate-700 hover:text-white active:bg-slate-700 transition-colors {{ app()->getLocale() === 'lv' ? 'bg-slate-700 text-white' : '' }}">
                                    {{ __('common.latvian') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white active:text-white transition-colors text-xs sm:text-sm font-medium py-2 px-1 min-h-[44px] flex items-center">{{ __('common.login') }}</a>
                    <a href="{{ route('register') }}" class="text-revolut-purple hover:text-revolut-purple-light active:opacity-90 transition-colors text-xs sm:text-sm font-medium py-2 px-2 min-h-[44px] flex items-center">{{ __('common.sign_up') }}</a>
                </div>
            </div>
        </div>
    </div>

<body class="font-sans bg-[#0c1222] min-h-screen overflow-x-hidden">
    <!-- Soft gradient overlay for depth -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-b from-[#0c1222] via-[#0f1729] to-[#0c1222] pointer-events-none"></div>

    <!-- Main Content -->
    <div class="welcome-main min-h-screen flex flex-col justify-center pt-[72px] pb-14 px-4 sm:pt-28 sm:pb-20 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto w-full">
            <!-- Hero -->
            <div class="text-center mb-14 sm:mb-20">
                <h1 class="text-4xl font-bold text-white mb-3 leading-[1.15] sm:text-5xl sm:mb-4 md:text-6xl">
                    {{ __('common.hero_title_part1') }}<br/>
                    <span class="bg-gradient-to-r from-violet-400 via-revolut-purple to-fuchsia-400 bg-clip-text text-transparent">{{ __('common.hero_title_part2') }}</span>
                </h1>
                <p class="text-gray-400 text-base sm:text-lg max-w-lg mx-auto mb-8 leading-relaxed">
                    {{ __('common.hero_subtitle') }}
                </p>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 max-w-sm mx-auto sm:max-w-none">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-revolut-purple to-violet-500 hover:from-revolut-purple-dark hover:to-violet-600 text-white font-semibold rounded-2xl transition-all duration-200 text-center shadow-lg shadow-revolut-purple/25">
                        {{ __('common.get_started') }}
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-transparent border-2 border-slate-500/60 hover:border-revolut-purple/50 text-white font-semibold rounded-2xl transition-all duration-200 text-center">
                        {{ __('common.login') }}
                    </a>
                </div>
            </div>

            <!-- Features: stacked, clear hierarchy -->
            <div class="space-y-10 sm:space-y-12">
                <div class="flex gap-4 sm:gap-5 items-start text-left">
                    <div class="w-14 h-14 rounded-full bg-slate-800/80 border-2 border-blue-400/40 flex items-center justify-center shrink-0 shadow-[0_0_20px_rgba(96,165,250,0.15)]">
                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1.5">{{ __('common.feature1_title') }}</h3>
                        <p class="text-gray-400 text-sm sm:text-base leading-relaxed">{{ __('common.feature1_description') }}</p>
                    </div>
                </div>

                <div class="flex gap-4 sm:gap-5 items-start text-left">
                    <div class="w-14 h-14 rounded-full bg-slate-800/80 border-2 border-emerald-400/40 flex items-center justify-center shrink-0 shadow-[0_0_20px_rgba(52,211,153,0.15)]">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1.5">{{ __('common.feature2_title') }}</h3>
                        <p class="text-gray-400 text-sm sm:text-base leading-relaxed">{{ __('common.feature2_description') }}</p>
                    </div>
                </div>

                <div class="flex gap-4 sm:gap-5 items-start text-left">
                    <div class="w-14 h-14 rounded-full bg-slate-800/80 border-2 border-violet-400/40 flex items-center justify-center shrink-0 shadow-[0_0_20px_rgba(167,139,250,0.15)]">
                        <svg class="w-7 h-7 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1.5">{{ __('common.feature3_title') }}</h3>
                        <p class="text-gray-400 text-sm sm:text-base leading-relaxed">{{ __('common.feature3_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @supports (padding: max(0px, env(safe-area-inset-top))) {
            .welcome-nav { padding-top: max(0.75rem, env(safe-area-inset-top)) !important; }
            .welcome-main { padding-top: max(72px, calc(72px + env(safe-area-inset-top))) !important; }
        }
    </style>
    <script>
        (function() {
            var toggle = document.getElementById('languageToggle');
            var dropdown = document.getElementById('languageDropdown');
            if (!toggle || !dropdown) return;
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });
            dropdown.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' || e.target.closest('a')) dropdown.classList.add('hidden');
            });
            document.addEventListener('click', function(e) {
                if (!toggle.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.add('hidden');
            });
        })();
    </script>
</body>
</html>
 