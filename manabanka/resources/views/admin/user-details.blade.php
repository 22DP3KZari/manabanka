@extends('layouts.admin')

@section('title', 'User: ' . $user->name)

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-green-500/20 border border-green-500/30 text-green-300 px-4 py-3" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
                @if (session('resetLink'))
                    <div class="mt-2 break-all bg-slate-800/60 p-2 rounded-lg border border-green-500/20 text-sm">{{ session('resetLink') }}</div>
                @endif
            </div>
        @endif

        <!-- User card -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div class="min-w-0">
                    <h2 class="text-base sm:text-lg font-semibold text-white">{{ __('common.admin_user_info') }}</h2>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('common.admin_name') }}</p>
                            <p class="mt-1 text-sm text-white">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('common.admin_email') }}</p>
                            <p class="mt-1 text-sm text-white">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('common.admin_joined') }}</p>
                            <p class="mt-1 text-sm text-gray-300">{{ $user->created_at->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('common.admin_status') }}</p>
                            <p class="mt-1"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">{{ __('common.admin_active') }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3 shrink-0">
                    <a href="{{ route('admin.users') }}" class="inline-flex items-center justify-center min-h-[44px] px-4 py-2 rounded-lg text-sm font-medium bg-slate-700/80 text-white border border-slate-600 hover:bg-slate-700 transition-colors">{{ __('common.admin_back_to_users') }}</a>
                    <button type="button" onclick="showResetPasswordModal()" class="inline-flex items-center justify-center min-h-[44px] px-4 py-2 rounded-lg text-sm font-medium bg-revolut-purple text-white hover:bg-revolut-purple-dark transition-colors">{{ __('common.admin_reset_password') }}</button>
                    <button type="button" onclick="confirmDelete({{ $user->id }}, {{ json_encode($user->name) }})" class="inline-flex items-center justify-center min-h-[44px] px-4 py-2 rounded-lg text-sm font-medium bg-red-600/80 text-white hover:bg-red-600 border border-red-500/30 transition-colors">{{ __('common.admin_delete_user') }}</button>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl overflow-hidden">
            <div class="px-4 py-4 sm:px-6 border-b border-slate-700/50">
                <h3 class="text-base sm:text-lg font-semibold text-white">{{ __('common.admin_recent_transactions') }}</h3>
            </div>
            <!-- Desktop: table -->
            <div class="hidden md:block">
                <table class="min-w-full divide-y divide-slate-700/50">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-400 uppercase sm:pl-6">{{ __('common.admin_recipient') }}</th>
                            <th class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase">{{ __('common.amount') }}</th>
                            <th class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase">{{ __('common.description') }}</th>
                            <th class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase">{{ __('common.date') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($user->transactions as $transaction)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="whitespace-nowrap py-4 pl-4 text-sm font-medium text-white sm:pl-6">{{ $transaction->recipient_name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">€{{ number_format($transaction->amount, 2) }}</td>
                            <td class="px-3 py-4 text-sm text-gray-400">{{ $transaction->description ?? '—' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-sm text-gray-400 text-center">{{ __('common.admin_no_transactions_yet') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Mobile: cards -->
            <div class="md:hidden divide-y divide-slate-700/50">
                @forelse($user->transactions as $transaction)
                <div class="px-4 py-3">
                    <div class="flex justify-between items-start gap-3">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-white">{{ $transaction->recipient_name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $transaction->description ?? '—' }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $transaction->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <span class="text-sm font-semibold text-gray-300 shrink-0">€{{ number_format($transaction->amount, 2) }}</span>
                    </div>
                </div>
                @empty
                <div class="px-4 py-8 text-sm text-gray-400 text-center">{{ __('common.admin_no_transactions_yet') }}</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Delete modal -->
    <div id="deleteModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-black/70" aria-hidden="true" onclick="closeModal()"></div>
        <div class="relative z-10 flex min-h-full items-center justify-center p-4 sm:p-6">
            <div class="w-full max-w-lg rounded-xl border border-slate-700 bg-slate-800 text-left shadow-xl overflow-hidden" onclick="event.stopPropagation()">
                <div class="px-4 pt-5 pb-4 sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-xl bg-red-500/20 border border-red-500/30 sm:mx-0">
                            <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-4">
                            <h3 class="text-lg font-semibold text-white">{{ __('common.admin_delete_user') }}</h3>
                            <p class="mt-2 text-sm text-gray-400">{{ __('common.admin_delete_confirm_prefix') }}<span id="userName" class="font-medium text-white"></span>{{ __('common.admin_delete_confirm_suffix') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-800/80 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                    <form id="deleteForm" method="POST" class="inline">@csrf @method('DELETE')
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center min-h-[44px] rounded-lg px-4 py-2 bg-red-600 text-sm font-medium text-white hover:bg-red-500">{{ __('common.delete') }}</button>
                    </form>
                    <button type="button" onclick="closeModal()" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center min-h-[44px] rounded-lg px-4 py-2 bg-slate-700 text-white hover:bg-slate-600 border border-slate-600">{{ __('common.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset password modal -->
    <div id="resetPasswordModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-black/70" aria-hidden="true" onclick="closeResetPasswordModal()"></div>
        <div class="relative z-10 flex min-h-full items-center justify-center p-4 sm:p-6">
            <form id="resetPasswordForm" method="POST" action="{{ route('admin.users.reset-password', $user->id) }}" class="w-full max-w-lg rounded-xl border border-slate-700 bg-slate-800 text-left shadow-xl overflow-hidden" onclick="event.stopPropagation()">
                @csrf
                <div class="px-4 pt-5 pb-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-white">{{ __('common.admin_reset_password') }}: {{ $user->name }}</h3>
                    <p class="mt-2 text-sm text-gray-400">{{ __('common.admin_reset_password_modal_body', ['email' => $user->email]) }}</p>
                </div>
                <div class="bg-slate-800/80 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center min-h-[44px] rounded-lg px-4 py-2 bg-revolut-purple text-white hover:bg-revolut-purple-dark text-sm font-medium">{{ __('common.admin_generate_reset_link') }}</button>
                    <button type="button" onclick="closeResetPasswordModal()" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center min-h-[44px] rounded-lg px-4 py-2 bg-slate-700 text-white hover:bg-slate-600 border border-slate-600">{{ __('common.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(userId, userName) {
            document.getElementById('userName').textContent = userName;
            document.getElementById('deleteForm').action = '/admin/users/' + userId;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeModal() { document.getElementById('deleteModal').classList.add('hidden'); }
        function showResetPasswordModal() { document.getElementById('resetPasswordModal').classList.remove('hidden'); }
        function closeResetPasswordModal() { document.getElementById('resetPasswordModal').classList.add('hidden'); }
    </script>
    @endpush
@endsection
