<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manaBanka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="font-sans bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 min-h-screen text-white overflow-x-hidden">
    <!-- Minimal floating navigation -->
    <div class="absolute top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 pt-6">
            <div class="flex justify-between items-center">
                <a href="/" class="text-xl font-bold text-white">manaBanka</a>
                <div class="flex items-center space-x-6">
                    <a href="/" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">{{ __('common.home') }}</a>
                    <a href="/contact" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">{{ __('common.contact') }}</a>
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">{{ __('common.login') }}</a>
                    <a href="{{ route('register') }}" class="text-revolut-purple hover:text-revolut-purple-light transition-colors text-sm font-medium">{{ __('common.sign_up') }}</a>
                </div>
            </div>
        </div>
    </div>

    <main class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-6xl mx-auto w-full">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-4 leading-tight">
                    {{ __('common.take_control') }}<br/>
                    <span class="bg-gradient-to-r from-revolut-purple via-revolut-violet to-revolut-purple bg-clip-text text-transparent">{{ __('common.your_finances') }}</span>
                </h1>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto mt-6">
                    {{ __('common.home_hero_subtitle') }}
                </p>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <!-- Today's Plan -->
                <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
                    <div class="flex items-center mb-4">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">{{ __('common.todays_plan') }}</h3>
                    </div>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li class="flex items-start">
                            <span class="text-revolut-purple mr-2">•</span>
                            <span>{{ __('common.plan_review') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-revolut-purple mr-2">•</span>
                            <span>{{ __('common.plan_emergency') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-revolut-purple mr-2">•</span>
                            <span>{{ __('common.plan_etf') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Budget Health -->
                <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
                    <div class="flex items-center mb-4">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">{{ __('common.budget_health') }}</h3>
                    </div>
                    <p class="text-gray-400 mb-3 text-xs">{{ __('common.budget_glance') }}</p>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li class="flex items-start">
                            <span class="text-green-400 mr-2">•</span>
                            <span>{{ __('common.budget_essentials') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-yellow-400 mr-2">•</span>
                            <span>{{ __('common.budget_fun') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-400 mr-2">•</span>
                            <span>{{ __('common.budget_savings') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Learning Path -->
                <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
                    <div class="flex items-center mb-4">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-revolut-purple/20 to-revolut-violet/20 border border-revolut-purple/30 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-revolut-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">{{ __('common.learning_path') }}</h3>
                    </div>
                    <p class="text-gray-400 mb-3 text-xs">{{ __('common.learning_subtitle') }}</p>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li class="flex items-start">
                            <span class="text-revolut-purple mr-2">•</span>
                            <span>{{ __('common.learning_etf') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-revolut-purple mr-2">•</span>
                            <span>{{ __('common.learning_automate') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-revolut-purple mr-2">•</span>
                            <span>{{ __('common.learning_risk') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Quick Actions -->
                <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
                    <div class="flex items-center mb-4">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-yellow-500/20 to-orange-500/20 border border-yellow-500/30 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">{{ __('common.quick_actions') }}</h3>
                    </div>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-revolut-purple hover:text-revolut-purple-light transition-colors flex items-center group text-sm">
                                <span class="mr-2">→</span>
                                <span>{{ __('common.action_expense') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-revolut-purple hover:text-revolut-purple-light transition-colors flex items-center group text-sm">
                                <span class="mr-2">→</span>
                                <span>{{ __('common.action_savings') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-revolut-purple hover:text-revolut-purple-light transition-colors flex items-center group text-sm">
                                <span class="mr-2">→</span>
                                <span>{{ __('common.action_etf') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Learn More Section -->
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 mt-4">
                <h3 class="text-lg font-semibold text-white mb-4">{{ __('common.learn_more') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="#article1" class="text-gray-400 hover:text-white transition-colors text-sm py-2 border-b border-slate-700/50 hover:border-revolut-purple/50">
                        {{ __('common.article_emergency') }}
                    </a>
                    <a href="#article2" class="text-gray-400 hover:text-white transition-colors text-sm py-2 border-b border-slate-700/50 hover:border-revolut-purple/50">
                        {{ __('common.article_etf') }}
                    </a>
                    <a href="#article3" class="text-gray-400 hover:text-white transition-colors text-sm py-2 border-b border-slate-700/50 hover:border-revolut-purple/50">
                        {{ __('common.article_budget') }}
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Subtle background elements -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-revolut-purple/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-revolut-violet/10 rounded-full blur-3xl"></div>
    </div>
</body>
</html>
