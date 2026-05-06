@extends('layouts.admin')

@section('title', __('common.admin_nav_users'))

@section('content')
    <div class="mb-4 sm:mb-6">
        <h1 class="text-lg sm:text-xl font-semibold text-white">{{ __('common.admin_nav_users') }}</h1>
        <p class="mt-1 text-xs sm:text-sm text-gray-400">{{ __('common.admin_users_subtitle') }}</p>
    </div>

    <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl overflow-hidden">
        <!-- Desktop: table -->
        <div class="hidden md:block">
            <table class="min-w-full divide-y divide-slate-700/50">
                <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider sm:pl-6">{{ __('common.admin_name') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.admin_email') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.admin_nav_transactions') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.admin_total_volume') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.admin_joined') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.admin_status') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider sm:pr-6">{{ __('common.admin_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <td class="whitespace-nowrap py-4 pl-4 text-sm font-medium text-white sm:pl-6">{{ $user->name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">{{ $user->email }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">{{ $user->spendings_count }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">€{{ number_format($user->spendings_sum_amount ?? 0, 2) }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">{{ __('common.admin_active') }}</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-medium sm:pr-6">
                            <div class="flex justify-end gap-3">
                                <button type="button" class="text-revolut-purple hover:text-revolut-purple-light transition-colors" onclick="viewUserDetails({{ $user->id }})">{{ __('common.view') }}</button>
                                <button type="button" class="text-red-400 hover:text-red-300 transition-colors" onclick="confirmDelete({{ $user->id }}, {{ json_encode($user->name) }})">{{ __('common.delete') }}</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile: cards -->
        <div class="md:hidden divide-y divide-slate-700/50">
            @foreach($users as $user)
            <div class="p-4 active:bg-slate-800/40 transition-colors">
                <div class="flex justify-between items-start gap-3">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-white truncate">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400 truncate mt-0.5">{{ $user->email }}</p>
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-xs text-gray-500">
                            <span>{{ $user->spendings_count }} ieraksti</span>
                            <span>€{{ number_format($user->spendings_sum_amount ?? 0, 2) }}</span>
                            <span>{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 shrink-0">
                        <button type="button" class="min-h-[44px] px-4 rounded-lg text-sm font-medium bg-revolut-purple/80 text-white border border-revolut-purple/50" onclick="viewUserDetails({{ $user->id }})">{{ __('common.view') }}</button>
                        <button type="button" class="min-h-[44px] px-4 rounded-lg text-sm font-medium text-red-400 border border-red-500/40" onclick="confirmDelete({{ $user->id }}, {{ json_encode($user->name) }})">{{ __('common.delete') }}</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="px-4 py-3 sm:px-6 border-t border-slate-700/50">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-black/70 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <div class="relative z-10 flex min-h-full items-center justify-center p-4 sm:p-6">
            <div class="w-full max-w-lg rounded-xl border border-slate-700 bg-slate-800 text-left overflow-hidden shadow-xl" onclick="event.stopPropagation()">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-xl bg-red-500/20 border border-red-500/30 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-semibold text-white" id="modal-title">{{ __('common.admin_delete_user') }}</h3>
                            <p class="mt-2 text-sm text-gray-400">{{ __('common.admin_delete_confirm_prefix') }}<span id="userName" class="font-medium text-white"></span>{{ __('common.admin_delete_confirm_suffix') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-800/80 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg px-4 py-3 sm:py-2 bg-red-600 text-sm font-medium text-white hover:bg-red-500 focus:outline-none sm:w-auto min-h-[44px] sm:min-h-0">{{ __('common.delete') }}</button>
                    </form>
                    <button type="button" onclick="closeModal()" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-lg px-4 py-3 sm:py-2 bg-slate-700 text-sm font-medium text-white hover:bg-slate-600 border border-slate-600 focus:outline-none sm:w-auto min-h-[44px] sm:min-h-0">{{ __('common.cancel') }}</button>
                </div>
            </div>
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
        function viewUserDetails(userId) { window.location.href = "{{ route('admin.users.show', '') }}/" + userId; }
    </script>
    @endpush
@endsection
