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

<body class="font-sans bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 min-h-screen overflow-x-hidden">
    <!-- Minimal floating navigation -->
    <div class="absolute top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 pt-6">
            <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-white">manaBanka</span>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">{{ __('common.login') }}</a>
                    <a href="{{ route('register') }}" class="text-revolut-purple hover:text-revolut-purple-light transition-colors text-sm font-medium">{{ __('common.sign_up') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-5xl mx-auto w-full">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <h1 class="text-6xl sm:text-7xl lg:text-8xl font-bold text-white mb-5 leading-tight">
                    {{ __('common.hero_title_part1') }}<br/>
                    <span class="bg-gradient-to-r from-revolut-purple via-revolut-violet to-revolut-purple bg-clip-text text-transparent">{{ __('common.hero_title_part2') }}</span>
                </h1>
                <p class="text-xl sm:text-2xl text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                    {{ __('common.hero_subtitle') }}
                </p>
                
                <!-- Primary CTA -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-12">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-6 py-2.5 bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium rounded-lg transition-all duration-200 text-sm shadow-md shadow-revolut-purple/20 hover:shadow-revolut-purple/30 hover:scale-[1.02]">
                        {{ __('common.get_started') }}
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-2.5 bg-transparent hover:bg-slate-800/30 border border-slate-600/50 hover:border-slate-500 text-white font-medium rounded-lg transition-all duration-200 text-sm">
                        {{ __('common.login') }}
                    </a>
                </div>
            </div>

            <!-- Features Section - More Minimal -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <!-- Feature 1 -->
                <div class="text-center group">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-white mb-2.5">{{ __('common.feature1_title') }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ __('common.feature1_description') }}</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center group">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-xl bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-white mb-2.5">{{ __('common.feature2_title') }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ __('common.feature2_description') }}</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center group">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-xl bg-gradient-to-br from-revolut-purple/20 to-revolut-violet/20 border border-revolut-purple/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-7 h-7 text-revolut-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-white mb-2.5">{{ __('common.feature3_title') }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ __('common.feature3_description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Subtle background elements -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-revolut-purple/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-revolut-violet/10 rounded-full blur-3xl"></div>
    </div>

</body>
</html> 