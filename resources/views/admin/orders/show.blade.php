<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order #{{ $order->id }}</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 underline">Back to orders</a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        @php
            $badge = match($order->status) {
                \App\Enums\OrderStatus::Pending    => 'bg-yellow-100 text-yellow-800',
                \App\Enums\OrderStatus::Processing => 'bg-blue-100 text-blue-800',
                \App\Enums\OrderStatus::Cancelled  => 'bg-gray-100 text-gray-600',
                \App\Enums\OrderStatus::Refunded   => 'bg-purple-100 text-purple-800',
            };
        @endphp

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 space-y-2">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-semibold shrink-0">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>
                    <div class="text-sm text-gray-600 space-y-0.5">
                        <p class="font-semibold text-gray-800">{{ $order->user->name }}</p>
                        <p class="text-gray-400">{{ $order->user->email }}</p>
                        <p class="text-gray-400">{{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-medium capitalize {{ $badge }}">{{ $order->status->value }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left">
                        <th class="px-6 py-3 text-gray-500 font-medium">Product</th>
                        <th class="px-6 py-3 text-gray-500 font-medium text-center">Qty</th>
                        <th class="px-6 py-3 text-gray-500 font-medium text-right">Unit Price</th>
                        <th class="px-6 py-3 text-gray-500 font-medium text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="px-6 py-4 text-gray-800">{{ $item->product->name }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-right text-gray-600">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-6 py-4 text-right font-medium text-gray-800">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t border-gray-100">
                    <tr>
                        <td colspan="3" class="px-6 py-4 font-semibold text-gray-800">Order Total</td>
                        <td class="px-6 py-4 text-right font-semibold text-indigo-600 text-base">${{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if(!$order->isRefunded())
            <div class="mt-4 flex justify-end">
                <form action="{{ route('admin.orders.refund', $order) }}" method="POST">
                    @csrf
                    <button class="bg-red-500 text-white text-sm rounded-lg px-6 py-2.5 hover:bg-red-600 transition font-medium">
                        Refund Order
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
