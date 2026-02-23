<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manaBanka - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col font-sans bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">
    <!-- Logo in top-left -->
    <div class="absolute top-6 left-6 z-10">
        <a href="/" class="flex items-center space-x-2">
            <span class="text-2xl font-bold text-white">manaBanka</span>
        </a>
    </div>

    <!-- Footer -->
    <div class="absolute bottom-6 left-6 z-10">
        <div class="relative">
            <button id="languageToggle" class="flex items-center space-x-1 text-gray-400 hover:text-white transition-colors text-sm focus:outline-none">
                <span>{{ app()->getLocale() === 'lv' ? __('common.latvian') : __('common.english') }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="languageDropdown" class="absolute bottom-full left-0 mb-1 hidden">
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
    </div>

    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md space-y-6">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-white mb-6">{{ __('common.enter_passcode') }}</h1>
                
                <!-- User identification (if email is remembered) -->
                @if(old('email'))
                    <div class="flex items-center justify-center space-x-3 mb-5">
                        <div class="w-9 h-9 rounded-full bg-revolut-purple flex items-center justify-center text-white font-semibold text-base">
                            {{ strtoupper(substr(old('email'), 0, 1)) }}
                        </div>
                        <div class="text-left">
                            <p class="text-white font-medium text-base">{{ old('email') }}</p>
                            <a href="#" class="text-revolut-purple hover:text-revolut-purple-light text-sm transition-colors">{{ __('common.not_you') }}</a>
                        </div>
                    </div>
                @endif
            </div>

            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-3 mb-4">
                    <p class="text-sm text-red-300 text-center">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </p>
                </div>
            @endif

            <form class="space-y-4" action="{{ route('login') }}" method="POST">
                @csrf
                
                @if(!old('email'))
                    <div>
                        <input id="email" name="email" type="email" required 
                            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm transition-all" 
                            placeholder="{{ __('common.email_address') }}"
                            value="{{ old('email') }}">
                    </div>
                @else
                    <input type="hidden" name="email" value="{{ old('email') }}">
                @endif

                <div class="relative">
                    <input id="password" name="password" type="password" required 
                        class="w-full px-4 py-3 pr-12 bg-slate-800/50 border border-slate-700 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm transition-all" 
                        placeholder="{{ __('common.password') }}"
                        autofocus>
                    <!-- Caps Lock Warning - Clean inline indicator -->
                    <div id="capsLockWarning" class="hidden absolute right-10 top-1/2 -translate-y-1/2">
                        <div class="flex items-center space-x-1 text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span class="text-xs font-medium">{{ __('common.caps_lock') }}</span>
                        </div>
                    </div>
                    <!-- Password visibility toggle -->
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

                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="text-sm text-revolut-purple hover:text-revolut-purple-light transition-colors">
                        {{ __('common.forgot_password_link') }}
                    </a>
                </div>

                <div>
                    <button type="submit" class="w-full py-2.5 bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium rounded-lg transition-all duration-200 text-sm shadow-md shadow-revolut-purple/20 hover:shadow-revolut-purple/30 hover:scale-[1.02]">
                        {{ __('common.continue') }}
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-gray-400 text-sm">
                        {{ __('common.no_account') }} 
                        <a href="{{ route('register') }}" class="text-revolut-purple hover:text-revolut-purple-light transition-colors">
                            {{ __('common.register_here') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script>
        // Password visibility toggle
        const passwordInput = document.querySelector('#password');
        const togglePassword = document.querySelector('#togglePassword');
        const eyeOpen = document.querySelector('#eyeOpen');
        const eyeClosed = document.querySelector('#eyeClosed');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                eyeOpen.classList.toggle('hidden');
                eyeClosed.classList.toggle('hidden');
            });
        }

        // Caps Lock warning - improved detection
        const capsLockWarning = document.querySelector('#capsLockWarning');

        if (passwordInput && capsLockWarning) {
            function checkCapsLock(e) {
                if (e && typeof e.getModifierState === 'function') {
                    const isCapsLockOn = e.getModifierState('CapsLock');
                    if (isCapsLockOn) {
                        capsLockWarning.classList.remove('hidden');
                    } else {
                        capsLockWarning.classList.add('hidden');
                    }
                }
            }

            // Check on every keydown and keyup
            passwordInput.addEventListener('keydown', checkCapsLock);
            passwordInput.addEventListener('keyup', checkCapsLock);
            
            // Also check when caps lock key is pressed
            document.addEventListener('keydown', function(e) {
                if (document.activeElement === passwordInput) {
                    if (e.key === 'CapsLock' || e.keyCode === 20 || e.code === 'CapsLock') {
                        // Check after a short delay to allow state to update
                        setTimeout(function() {
                            // Trigger a check by creating a synthetic event
                            const syntheticEvent = {
                                getModifierState: function(key) {
                                    if (key === 'CapsLock') {
                                        // We can't directly check, but the next real keypress will show it
                                        return false;
                                    }
                                    return false;
                                }
                            };
                            checkCapsLock(syntheticEvent);
                        }, 10);
                    }
                }
            });
        }

        // Language dropdown toggle
        const languageToggle = document.getElementById('languageToggle');
        const languageDropdown = document.getElementById('languageDropdown');

        if (languageToggle && languageDropdown) {
            languageToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                languageDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking on language links (use event delegation)
            languageDropdown.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' || e.target.closest('a')) {
                    languageDropdown.classList.add('hidden');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!languageToggle.contains(e.target) && !languageDropdown.contains(e.target)) {
                    languageDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html> 