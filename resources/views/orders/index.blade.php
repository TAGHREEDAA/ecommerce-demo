<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Orders</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                You have no orders yet. <a href="{{ route('dashboard') }}" class="text-indigo-600 underline">Browse products</a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-left">
                            <th class="px-6 py-3 text-gray-500 font-medium">Order</th>
                            <th class="px-6 py-3 text-gray-500 font-medium">Status</th>
                            <th class="px-6 py-3 text-gray-500 font-medium text-right">Total</th>
                            <th class="px-6 py-3 text-gray-500 font-medium text-right">Date</th>
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
                                    <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:underline font-medium">#{{ $order->id }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $badge }}">{{ $order->status->value }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-gray-800">${{ number_format($order->total_price, 2) }}</td>
                                <td class="px-6 py-4 text-right text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
