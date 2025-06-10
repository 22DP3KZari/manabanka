<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>manaBanka - Dashboard</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')

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
                    <a href="{{ route('budget-planner.index') }}" class="bg-green-600 text-white p-4 rounded-lg hover:bg-green-700 transition text-center">
                        Budget Planner
                    </a>
                    <a href="{{ route('budgets.index') }}" class="bg-yellow-600 text-white p-4 rounded-lg hover:bg-yellow-700 transition text-center">
                        My Budgets
                    </a>
                    <a href="{{ route('statements.index') }}" class="bg-gray-600 text-white p-4 rounded-lg hover:bg-gray-700 transition text-center">
                        View Statements
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html> 