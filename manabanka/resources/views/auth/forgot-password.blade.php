<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('common.password_reset') }} - manaBanka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col font-sans bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">
    <div class="absolute top-6 left-6 z-10">
        <a href="/" class="flex items-center space-x-2">
            <span class="text-2xl font-bold text-white">manaBanka</span>
        </a>
    </div>

    <div class="absolute bottom-6 left-6 z-10">
        <div class="relative">
            <button id="languageToggle" class="flex items-center space-x-1 text-gray-400 hover:text-white transition-colors text-sm focus:outline-none">
                <span>{{ app()->getLocale() === 'lv' ? __('common.latvian') : __('common.english') }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="languageDropdown" class="absolute bottom-full left-0 mb-1 hidden">
                <div class="bg-slate-800/95 backdrop-blur-sm border border-slate-700 rounded-lg shadow-lg overflow-hidden min-w-[160px]">
                    <a href="{{ route('lang.switch', 'en') }}?back={{ urlencode(request()->fullUrl()) }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white transition-colors {{ app()->getLocale() === 'en' ? 'bg-slate-700 text-white' : '' }}">{{ __('common.english') }}</a>
                    <a href="{{ route('lang.switch', 'lv') }}?back={{ urlencode(request()->fullUrl()) }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white transition-colors {{ app()->getLocale() === 'lv' ? 'bg-slate-700 text-white' : '' }}">{{ __('common.latvian') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md space-y-6">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-white mb-2">{{ __('common.forgot_password_title') }}</h1>
                <p class="text-gray-400 text-sm">{{ __('common.forgot_password_help') }}</p>
            </div>

            @if (session('status'))
                <div class="bg-green-500/20 border border-green-500/50 rounded-lg p-4 text-center">
                    <p class="text-sm text-green-300">{{ session('status') }}</p>
                </div>
                <p class="text-center text-gray-400 text-sm">{{ __('common.forgot_password_check_inbox') }}</p>
            @endif

            @if (!$errors->isEmpty())
                <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-3">
                    <p class="text-sm text-red-300 text-center">{{ $errors->first() }}</p>
                </div>
            @endif

            @if (!session('status'))
            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input type="email" name="email" required autocomplete="email" value="{{ old('email') }}"
                           class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm"
                           placeholder="{{ __('common.email_address') }}">
                </div>
                <button type="submit" class="w-full py-2.5 bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium rounded-lg transition-colors text-sm">
                    {{ __('common.send_reset_link') }}
                </button>
            </form>
            @endif

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-revolut-purple hover:text-revolut-purple-light transition-colors">
                    {{ __('common.back_to_login') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var languageToggle = document.getElementById('languageToggle');
            var languageDropdown = document.getElementById('languageDropdown');
            if (languageToggle && languageDropdown) {
                languageToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    languageDropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', function(e) {
                    if (!languageToggle.contains(e.target) && !languageDropdown.contains(e.target)) {
                        languageDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
