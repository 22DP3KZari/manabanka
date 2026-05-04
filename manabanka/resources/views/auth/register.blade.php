<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manaBanka - Register</title>
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
                <h1 class="text-3xl font-bold text-white mb-1.5">{{ __('common.create_account') }}</h1>
                <p class="text-gray-400 text-sm">{{ __('common.join_subtitle') }}</p>
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

            <form class="space-y-4" action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <input id="first_name" name="first_name" type="text" required 
                                minlength="2"
                                maxlength="30"
                                pattern="[\p{L}\-']+"
                                title="First name must be 2-30 characters and can only contain letters and hyphens/apostrophes (no spaces, dots, or commas)"
                                class="w-full px-4 py-3 bg-slate-800/50 border {{ $errors->has('first_name') ? 'border-red-500/50' : 'border-slate-700' }} placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm transition-all" 
                                placeholder="{{ __('common.first_name') }}"
                                value="{{ old('first_name') }}">
                            @error('first_name')
                                <p class="mt-1 text-xs text-red-300 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input id="last_name" name="last_name" type="text" required 
                                minlength="2"
                                maxlength="30"
                                pattern="[\p{L}\-']+"
                                title="Last name must be 2-30 characters and can only contain letters and hyphens/apostrophes (no spaces, dots, or commas)"
                                class="w-full px-4 py-3 bg-slate-800/50 border {{ $errors->has('last_name') ? 'border-red-500/50' : 'border-slate-700' }} placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm transition-all" 
                                placeholder="{{ __('common.last_name') }}"
                                value="{{ old('last_name') }}">
                            @error('last_name')
                                <p class="mt-1 text-xs text-red-300 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <input id="email" name="email" type="email" required 
                            maxlength="30"
                            class="w-full px-4 py-3 bg-slate-800/50 border {{ $errors->has('email') ? 'border-red-500/50' : 'border-slate-700' }} placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm transition-all" 
                            placeholder="{{ __('common.email_address') }}"
                            value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-xs text-red-300 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="relative">
                        <input id="password" name="password" type="password" required 
                            class="w-full px-4 py-3 pr-12 bg-slate-800/50 border border-slate-700 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm transition-all" 
                            placeholder="{{ __('common.create_password') }}">
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
                    
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                            class="w-full px-4 py-3 pr-12 bg-slate-800/50 border border-slate-700 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-left text-sm transition-all" 
                            placeholder="{{ __('common.confirm_password') }}">
                        <!-- Caps Lock Warning - Clean inline indicator -->
                        <div id="capsLockWarningConfirm" class="hidden absolute right-10 top-1/2 -translate-y-1/2">
                            <div class="flex items-center space-x-1 text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span class="text-xs font-medium">{{ __('common.caps_lock') }}</span>
                            </div>
                        </div>
                        <!-- Password visibility toggle -->
                        <button type="button" id="togglePasswordConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors focus:outline-none">
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

                <!-- Password Strength Indicator -->
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs font-medium text-gray-300">{{ __('common.password_strength') }}</span>
                        <span id="passwordStrength" class="text-xs font-medium text-gray-300" data-too-weak="{{ __('common.password_too_weak') }}" data-weak="{{ __('common.password_weak') }}" data-fair="{{ __('common.password_fair') }}" data-good="{{ __('common.password_good') }}" data-strong="{{ __('common.password_strong') }}">{{ __('common.password_too_weak') }}</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-1.5">
                        <div id="passwordStrengthBar" class="h-1.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <ul class="mt-2 text-xs text-gray-400 space-y-1">
                        <li id="lengthCheck" class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('common.password_length') }}
                        </li>
                        <li id="uppercaseCheck" class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('common.password_uppercase') }}
                        </li>
                        <li id="lowercaseCheck" class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('common.password_lowercase') }}
                        </li>
                        <li id="numberCheck" class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('common.password_number') }}
                        </li>
                        <li id="specialCheck" class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('common.password_special') }}
                        </li>
                    </ul>
                </div>

                <div>
                    <button type="submit" class="w-full py-2.5 bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium rounded-lg transition-all duration-200 text-sm shadow-md shadow-revolut-purple/20 hover:shadow-revolut-purple/30 hover:scale-[1.02]">
                        {{ __('common.create_account') }}
                    </button>
                </div>

                <div class="text-xs text-center">
                    <a href="{{ route('login') }}" class="text-revolut-purple hover:text-revolut-purple-light transition-colors">
                        {{ __('common.have_account') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password visibility toggles
        const passwordInput = document.querySelector('#password');
        const passwordConfirmInput = document.querySelector('#password_confirmation');
        const togglePassword = document.querySelector('#togglePassword');
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const eyeOpen = document.querySelector('#eyeOpen');
        const eyeClosed = document.querySelector('#eyeClosed');
        const eyeOpenConfirm = document.querySelector('#eyeOpenConfirm');
        const eyeClosedConfirm = document.querySelector('#eyeClosedConfirm');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                eyeOpen.classList.toggle('hidden');
                eyeClosed.classList.toggle('hidden');
            });
        }

        if (togglePasswordConfirm && passwordConfirmInput) {
            togglePasswordConfirm.addEventListener('click', function() {
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                eyeOpenConfirm.classList.toggle('hidden');
                eyeClosedConfirm.classList.toggle('hidden');
            });
        }

        // Caps Lock warning - improved detection
        const capsLockWarning = document.querySelector('#capsLockWarning');
        const capsLockWarningConfirm = document.querySelector('#capsLockWarningConfirm');

        function setupCapsLockWarning(input, warningElement) {
            if (input && warningElement) {
                function checkCapsLock(e) {
                    if (e && typeof e.getModifierState === 'function') {
                        const isCapsLockOn = e.getModifierState('CapsLock');
                        if (isCapsLockOn) {
                            warningElement.classList.remove('hidden');
                        } else {
                            warningElement.classList.add('hidden');
                        }
                    }
                }

                // Check on every keydown and keyup
                input.addEventListener('keydown', checkCapsLock);
                input.addEventListener('keyup', checkCapsLock);
                
                // Also check when caps lock key is pressed
                document.addEventListener('keydown', function(e) {
                    if (document.activeElement === input) {
                        if (e.key === 'CapsLock' || e.keyCode === 20 || e.code === 'CapsLock') {
                            // Check after a short delay to allow state to update
                            setTimeout(function() {
                                // Trigger a check by creating a synthetic event
                                const syntheticEvent = {
                                    getModifierState: function(key) {
                                        if (key === 'CapsLock') {
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
        }

        setupCapsLockWarning(passwordInput, capsLockWarning);
        setupCapsLockWarning(passwordConfirmInput, capsLockWarningConfirm);

        // Password strength indicator
        const password = document.querySelector('#password');
        const strengthBar = document.querySelector('#passwordStrengthBar');
        const strengthText = document.querySelector('#passwordStrength');
        const checks = {
            length: document.querySelector('#lengthCheck'),
            uppercase: document.querySelector('#uppercaseCheck'),
            lowercase: document.querySelector('#lowercaseCheck'),
            number: document.querySelector('#numberCheck'),
            special: document.querySelector('#specialCheck')
        };

        function updatePasswordStrength(password) {
            const checks = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[^A-Za-z0-9]/.test(password)
            };

            // Update checkmarks
            Object.entries(checks).forEach(([key, passed]) => {
                const check = document.querySelector(`#${key}Check`);
                check.querySelector('svg').innerHTML = passed
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                check.classList.toggle('text-green-400', passed);
                check.classList.toggle('text-gray-400', !passed);
            });

            // Calculate strength
            const strength = Object.values(checks).filter(Boolean).length;
            const strengthPercent = (strength / 5) * 100;
            
            // Update strength bar
            strengthBar.style.width = `${strengthPercent}%`;
            
            // Update colors and text
            if (strengthPercent <= 20) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-red-500';
                strengthText.textContent = strengthText.getAttribute('data-too-weak');
            } else if (strengthPercent <= 40) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-orange-500';
                strengthText.textContent = strengthText.getAttribute('data-weak');
            } else if (strengthPercent <= 60) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-yellow-500';
                strengthText.textContent = strengthText.getAttribute('data-fair');
            } else if (strengthPercent <= 80) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-blue-500';
                strengthText.textContent = strengthText.getAttribute('data-good');
            } else {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-green-500';
                strengthText.textContent = strengthText.getAttribute('data-strong');
            }
        }

        password.addEventListener('input', (e) => {
            updatePasswordStrength(e.target.value);
        });

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