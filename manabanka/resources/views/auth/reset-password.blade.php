<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - manaBanka</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Reset your password
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Please enter your new password below
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror"
                                value="{{ $email ?? old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            New Password
                        </label>
                        <div class="mt-1 relative">
                            <input id="password" name="password" type="password" required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-500 @enderror">
                            <button type="button" id="togglePassword" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div class="password-strength-meter">
                                <div class="strength-meter-fill" data-strength="0"></div>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                Password must be at least 8 characters long and include:
                                <ul class="list-disc list-inside text-xs text-gray-500 mt-1">
                                    <li id="length">At least 8 characters</li>
                                    <li id="uppercase">One uppercase letter</li>
                                    <li id="lowercase">One lowercase letter</li>
                                    <li id="number">One number</li>
                                    <li id="special">One special character</li>
                                </ul>
                            </p>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Confirm Password
                        </label>
                        <div class="mt-1 relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <button type="button" id="toggleConfirmPassword" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .password-strength-meter {
            height: 4px;
            background-color: #e2e8f0;
            border-radius: 2px;
            margin: 10px 0;
        }
        .strength-meter-fill {
            height: 100%;
            border-radius: 2px;
            transition: width 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }
        .strength-meter-fill[data-strength="0"] { width: 0; background-color: #e2e8f0; }
        .strength-meter-fill[data-strength="1"] { width: 20%; background-color: #ef4444; }
        .strength-meter-fill[data-strength="2"] { width: 40%; background-color: #f97316; }
        .strength-meter-fill[data-strength="3"] { width: 60%; background-color: #eab308; }
        .strength-meter-fill[data-strength="4"] { width: 80%; background-color: #84cc16; }
        .strength-meter-fill[data-strength="5"] { width: 100%; background-color: #22c55e; }
    </style>

    <script>
        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('svg').style.display = type === 'password' ? 'block' : 'none';
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('svg').style.display = type === 'password' ? 'block' : 'none';
        });

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthMeter = document.querySelector('.strength-meter-fill');
        const requirements = {
            length: document.getElementById('length'),
            uppercase: document.getElementById('uppercase'),
            lowercase: document.getElementById('lowercase'),
            number: document.getElementById('number'),
            special: document.getElementById('special')
        };

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Check length
            if (password.length >= 8) {
                strength++;
                requirements.length.style.color = '#22c55e';
            } else {
                requirements.length.style.color = '#6b7280';
            }

            // Check uppercase
            if (/[A-Z]/.test(password)) {
                strength++;
                requirements.uppercase.style.color = '#22c55e';
            } else {
                requirements.uppercase.style.color = '#6b7280';
            }

            // Check lowercase
            if (/[a-z]/.test(password)) {
                strength++;
                requirements.lowercase.style.color = '#22c55e';
            } else {
                requirements.lowercase.style.color = '#6b7280';
            }

            // Check number
            if (/[0-9]/.test(password)) {
                strength++;
                requirements.number.style.color = '#22c55e';
            } else {
                requirements.number.style.color = '#6b7280';
            }

            // Check special character
            if (/[^A-Za-z0-9]/.test(password)) {
                strength++;
                requirements.special.style.color = '#22c55e';
            } else {
                requirements.special.style.color = '#6b7280';
            }

            strengthMeter.setAttribute('data-strength', strength);
        });
    </script>
</body>
</html> 