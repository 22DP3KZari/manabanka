<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transfer Money - manaBanka</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-600">manaBanka</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-700 mr-4">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Transfer Money
                        </h3>
                        
                        @if ($errors->any())
                            <div class="mt-4 bg-red-50 border-l-4 border-red-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}<br>
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('transfers.store') }}" method="POST" class="mt-5 space-y-6">
                            @csrf
                            
                            <div>
                                <label for="recipient_account" class="block text-sm font-medium text-gray-700">
                                    Recipient Account Number
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="recipient_account" id="recipient_account" 
                                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Enter recipient's bank account number"
                                        value="{{ old('recipient_account') }}"
                                        maxlength="34"
                                        pattern="[A-Za-z0-9]+"
                                        required>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Enter the recipient's bank account number (e.g., LV36HABA0551047225371)
                                </p>
                            </div>

                            <div>
                                <label for="recipient_name" class="block text-sm font-medium text-gray-700">
                                    Recipient Name
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="recipient_name" id="recipient_name" 
                                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Enter recipient's full name"
                                        value="{{ old('recipient_name') }}"
                                        required>
                                </div>
                            </div>

                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">
                                    Amount
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">€</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" 
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                        placeholder="0.00"
                                        step="0.01"
                                        min="0.01"
                                        max="10000"
                                        value="{{ old('amount') }}"
                                        required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">EUR</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Description (Optional)
                                </label>
                                <div class="mt-1">
                                    <textarea name="description" id="description" rows="3" 
                                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Enter a description for this transfer">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Transfer Money
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Format account number input
        const accountInput = document.getElementById('recipient_account');
        accountInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^A-Za-z0-9]/g, '').slice(0, 34);
        });

        // Format amount input
        const amountInput = document.getElementById('amount');
        amountInput.addEventListener('input', function(e) {
            if (this.value < 0) this.value = 0;
            if (this.value > 10000) this.value = 10000;
        });
    </script>
</body>
</html> 