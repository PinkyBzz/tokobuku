@extends('layouts.admin')

@section('title', 'Manage Orders')
@section('page-title', 'Manage Orders')

@section('content')
<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid md:grid-cols-5 gap-4">
        <div class="bg-white border border-gray-100 rounded-sm p-4 text-center">
            <p class="text-2xl font-medium text-gray-900 serif">{{ $stats['pending'] ?? 0 }}</p>
            <p class="text-xs uppercase tracking-widest text-gray-500 mt-1">Pending</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-sm p-4 text-center">
            <p class="text-2xl font-medium text-gray-900 serif">{{ $stats['paid'] ?? 0 }}</p>
            <p class="text-xs uppercase tracking-widest text-gray-500 mt-1">Paid</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-sm p-4 text-center">
            <p class="text-2xl font-medium text-gray-900 serif">{{ $stats['processed'] ?? 0 }}</p>
            <p class="text-xs uppercase tracking-widest text-gray-500 mt-1">Processed</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-sm p-4 text-center">
            <p class="text-2xl font-medium text-gray-900 serif">{{ $stats['shipped'] ?? 0 }}</p>
            <p class="text-xs uppercase tracking-widest text-gray-500 mt-1">Shipped</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-sm p-4 text-center">
            <p class="text-2xl font-medium text-gray-900 serif">{{ $stats['delivered'] ?? 0 }}</p>
            <p class="text-xs uppercase tracking-widest text-gray-500 mt-1">Delivered</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border border-gray-100 rounded-sm p-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Search</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Invoice or customer name..."
                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
            </div>
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Status</label>
                <select name="status" 
                        class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Payment Method</label>
                <select name="payment_method" 
                        class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
                    <option value="">All Methods</option>
                    <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="ewallet" {{ request('payment_method') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                    <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>COD</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 bg-gray-900 hover:bg-gray-800 text-white px-4 py-3 transition-colors text-xs uppercase tracking-widest">
                    Filter
                </button>
                <a href="{{ route('admin.orders.index') }}" 
                   class="px-4 py-3 bg-white border border-gray-200 hover:border-gray-900 text-gray-900 text-xs uppercase tracking-widest transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white border border-gray-100 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Invoice</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Items</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Payment</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-widest text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-900">#{{ $order->invoice_number }}</p>
                                <p class="text-xs text-gray-500 font-light mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-500 font-light mt-1">{{ $order->user->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 font-light">{{ $order->items->count() }} items</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs uppercase tracking-widest text-gray-600">{{ $order->metode_pembayaran }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs uppercase tracking-widest rounded-full
                                    @if($order->status == 'pending') bg-yellow-50 text-yellow-700
                                    @elseif($order->status == 'paid') bg-blue-50 text-blue-700
                                    @elseif($order->status == 'processed') bg-purple-50 text-purple-700
                                    @elseif($order->status == 'shipped') bg-indigo-50 text-indigo-700
                                    @elseif($order->status == 'delivered') bg-green-50 text-green-700
                                    @else bg-red-50 text-red-700
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="px-3 py-2 text-xs uppercase tracking-widest text-gray-600 hover:text-gray-900 border border-gray-200 hover:border-gray-900 transition-colors">
                                        View
                                    </a>
                                    @if($order->status != 'delivered' && $order->status != 'cancelled')
                                        <button onclick="updateStatus({{ $order->id }})"
                                                class="px-3 py-2 text-xs uppercase tracking-widest text-blue-600 hover:text-blue-800 border border-blue-200 hover:border-blue-600 transition-colors">
                                            Update
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <p class="text-sm text-gray-500 font-light">No orders found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function updateStatus(orderId) {
    // Placeholder - implement status update modal
    alert('Update order status functionality - to be implemented');
}
</script>
@endsection
