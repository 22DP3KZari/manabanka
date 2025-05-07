<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManaBanka - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-blue-600">ManaBanka</span>
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
        <!-- Account Overview -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Account Overview</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-blue-900">Main Account</h3>
                        <p class="text-2xl font-bold text-blue-600">€0.00</p>
                        <p class="text-sm text-blue-700">Available Balance</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-green-900">Savings</h3>
                        <p class="text-2xl font-bold text-green-600">€0.00</p>
                        <p class="text-sm text-green-700">Total Savings</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-purple-900">Credit Card</h3>
                        <p class="text-2xl font-bold text-purple-600">€0.00</p>
                        <p class="text-sm text-purple-700">Available Credit</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('transfers.create') }}" class="bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 transition text-center">
                        Transfer Money
                    </a>
                    <button class="bg-green-600 text-white p-4 rounded-lg hover:bg-green-700 transition cursor-not-allowed" disabled>
                        Pay Bills
                        <span class="block text-sm text-gray-200">Coming Soon</span>
                    </button>
                    <button class="bg-purple-600 text-white p-4 rounded-lg hover:bg-purple-700 transition cursor-not-allowed" disabled>
                        Apply for Loan
                        <span class="block text-sm text-gray-200">Coming Soon</span>
                    </button>
                    <button class="bg-gray-600 text-white p-4 rounded-lg hover:bg-gray-700 transition cursor-not-allowed" disabled>
                        View Statements
                        <span class="block text-sm text-gray-200">Coming Soon</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
</body>
</html> 