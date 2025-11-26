@extends('layouts.admin')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')
<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white border border-gray-100 rounded-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Total Users</p>
                    <p class="text-3xl font-medium text-gray-900 serif">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-gray-900"></i>
                </div>
            </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Admins</p>
                    <p class="text-3xl font-medium text-gray-900 serif">{{ $adminUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-shield text-gray-900"></i>
                </div>
            </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Active Users</p>
                    <p class="text-3xl font-medium text-gray-900 serif">{{ $activeUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-gray-900"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border border-gray-100 rounded-sm p-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Search</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Name or email..."
                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
            </div>
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Role</label>
                <select name="role" 
                        class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 bg-gray-900 hover:bg-gray-800 text-white px-4 py-3 transition-colors text-xs uppercase tracking-widest">
                    Filter
                </button>
                <a href="{{ route('admin.users.index') }}" 
                   class="px-4 py-3 bg-white border border-gray-200 hover:border-gray-900 text-gray-900 text-xs uppercase tracking-widest transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white border border-gray-100 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">User</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Orders</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Joined</th>
                        <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-widest text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-sm font-medium">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 font-light">{{ $user->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs uppercase tracking-widest rounded-full
                                    @if($user->role == 'admin') bg-purple-50 text-purple-700
                                    @else bg-blue-50 text-blue-700
                                    @endif">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 font-light">{{ $user->orders_count ?? 0 }} orders</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 font-light">{{ $user->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if($user->id != Auth::id())
                                        <form method="POST" 
                                              action="{{ route('admin.users.toggle-role', $user) }}"
                                              class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="px-3 py-2 text-xs uppercase tracking-widest text-gray-600 hover:text-gray-900 border border-gray-200 hover:border-gray-900 transition-colors">
                                                {{ $user->role == 'admin' ? 'Make Customer' : 'Make Admin' }}
                                            </button>
                                        </form>
                                        <form method="POST" 
                                              action="{{ route('admin.users.destroy', $user) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete this user?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-2 text-xs uppercase tracking-widest text-red-600 hover:text-red-800 border border-red-200 hover:border-red-600 transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 italic">(You)</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-sm text-gray-500 font-light">No users found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
