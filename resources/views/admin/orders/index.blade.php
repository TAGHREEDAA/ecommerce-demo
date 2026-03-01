<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Orders</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-4">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">No orders yet.</div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-left">
                            <th class="px-6 py-3 text-gray-500 font-medium">Order</th>
                            <th class="px-6 py-3 text-gray-500 font-medium">Customer</th>
                            <th class="px-6 py-3 text-gray-500 font-medium">Status</th>
                            <th class="px-6 py-3 text-gray-500 font-medium text-right">Total</th>
                            <th class="px-6 py-3 text-gray-500 font-medium text-right">Date</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $badge = match($order->status) {
                                    \App\Enums\OrderStatus::Pending    => 'bg-yellow-100 text-yellow-800',
                                    \App\Enums\OrderStatus::Processing => 'bg-blue-100 text-blue-800',
                                    \App\Enums\OrderStatus::Cancelled  => 'bg-gray-100 text-gray-600',
                                    \App\Enums\OrderStatus::Refunded   => 'bg-purple-100 text-purple-800',
                                };
                            @endphp
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline font-medium">#{{ $order->id }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-7 w-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold shrink-0">
                                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-800">{{ $order->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $badge }}">{{ $order->status->value }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-gray-800">${{ number_format($order->total_price, 2) }}</td>
                                <td class="px-6 py-4 text-right text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    @if(!$order->isRefunded())
                                        <form action="{{ route('admin.orders.refund', $order) }}" method="POST">
                                            @csrf
                                            <button class="text-xs text-white bg-red-500 hover:bg-red-600 transition rounded-lg px-3 py-1.5">Refund</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">Refunded</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
