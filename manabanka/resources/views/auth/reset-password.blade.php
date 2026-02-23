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
            <button id="languageToggle" type="button" class="flex items-center space-x-1 text-gray-400 hover:text-white transition-colors text-sm focus:outline-none">
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
                <h1 class="text-3xl font-bold text-white mb-2">{{ __('common.reset_password_title') }}</h1>
                <p class="text-gray-400 text-sm">{{ __('common.reset_password_help') }}</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-3">
                    <p class="text-sm text-red-300 text-center">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-1">{{ __('common.email_address') }}</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           value="{{ $email ?? old('email') }}"
                           class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm @error('email') border-red-500/50 @enderror"
                           placeholder="{{ __('common.email_address') }}">
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-1">{{ __('common.new_password') }}</label>
                    <div class="relative">
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-3 pr-12 bg-slate-800/50 border border-slate-700 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm @error('password') border-red-500/50 @enderror"
                           placeholder="{{ __('common.new_password') }}">
                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors focus:outline-none">
                        <svg id="eyeOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m13.42 13.42l-3.29-3.29M3 3l18 18" />
                        </svg>
                    </button>
                    </div>
                <div class="mt-1.5">
                    <p class="text-xs text-gray-400 mb-1">{{ __('common.password_strength') }}</p>
                    <div class="h-1 bg-slate-700 rounded-full overflow-hidden">
                        <div id="strengthMeter" class="h-full rounded-full transition-all duration-300 w-0 bg-slate-500" data-strength="0"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 mb-1">{{ __('common.password_must_include') }}</p>
                    <ul class="text-xs text-gray-500 space-y-0.5">
                        <li id="req-length">{{ __('common.password_length') }}</li>
                        <li id="req-uppercase">{{ __('common.password_uppercase') }}</li>
                        <li id="req-lowercase">{{ __('common.password_lowercase') }}</li>
                        <li id="req-number">{{ __('common.password_number') }}</li>
                        <li id="req-special">{{ __('common.password_special') }}</li>
                    </ul>
                </div>
                @error('password')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-400 mb-1">{{ __('common.confirm_password') }}</label>
                    <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full px-4 py-3 pr-12 bg-slate-800/50 border border-slate-700 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm"
                           placeholder="{{ __('common.confirm_password') }}">
                    <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors focus:outline-none">
                        <svg id="eyeOpenConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosedConfirm" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m13.42 13.42l-3.29-3.29M3 3l18 18" />
                        </svg>
                    </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium rounded-lg transition-colors text-sm">
                    {{ __('common.reset_password_button') }}
                </button>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-revolut-purple hover:text-revolut-purple-light transition-colors">
                    {{ __('common.back_to_login') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var langToggle = document.getElementById('languageToggle');
            var langDropdown = document.getElementById('languageDropdown');
            if (langToggle && langDropdown) {
                langToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    langDropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', function(e) {
                    if (!langToggle.contains(e.target) && !langDropdown.contains(e.target)) langDropdown.classList.add('hidden');
                });
            }

            function toggleEye(button, inputId, openId, closedId) {
                var input = document.getElementById(inputId);
                var open = document.getElementById(openId);
                var closed = document.getElementById(closedId);
                if (!input || !open || !closed) return;
                var isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                open.classList.toggle('hidden', !isPassword);
                closed.classList.toggle('hidden', isPassword);
            }
            document.getElementById('togglePassword').addEventListener('click', function() {
                toggleEye(this, 'password', 'eyeOpen', 'eyeClosed');
            });
            document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                toggleEye(this, 'password_confirmation', 'eyeOpenConfirm', 'eyeClosedConfirm');
            });

            var passwordInput = document.getElementById('password');
            var strengthMeter = document.getElementById('strengthMeter');
            var reqs = {
                length: document.getElementById('req-length'),
                uppercase: document.getElementById('req-uppercase'),
                lowercase: document.getElementById('req-lowercase'),
                number: document.getElementById('req-number'),
                special: document.getElementById('req-special')
            };
            var metClass = 'text-emerald-400';
            var unmetClass = 'text-gray-500';

            passwordInput.addEventListener('input', function() {
                var p = this.value;
                var strength = 0;
                if (p.length >= 8) { strength++; reqs.length.className = metClass; } else { reqs.length.className = unmetClass; }
                if (/[A-Z]/.test(p)) { strength++; reqs.uppercase.className = metClass; } else { reqs.uppercase.className = unmetClass; }
                if (/[a-z]/.test(p)) { strength++; reqs.lowercase.className = metClass; } else { reqs.lowercase.className = unmetClass; }
                if (/[0-9]/.test(p)) { strength++; reqs.number.className = metClass; } else { reqs.number.className = unmetClass; }
                if (/[^A-Za-z0-9]/.test(p)) { strength++; reqs.special.className = metClass; } else { reqs.special.className = unmetClass; }

                var w = strength * 20;
                strengthMeter.style.width = w + '%';
                strengthMeter.setAttribute('data-strength', strength);
                if (strength <= 1) strengthMeter.style.backgroundColor = 'rgb(239 68 68)';
                else if (strength <= 3) strengthMeter.style.backgroundColor = 'rgb(245 158 11)';
                else strengthMeter.style.backgroundColor = 'rgb(16 185 129)';
            });
        });
    </script>
</body>
</html>
