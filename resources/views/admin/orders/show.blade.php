<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order #{{ $order->id }}</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 underline">Back to orders</a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        @if(session('success'))
            <p class="mb-6 text-green-600">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p class="mb-6 text-red-600">{{ session('error') }}</p>
        @endif

        <div class="mb-6 text-sm text-gray-600 space-y-1">
            <p>Customer: <span class="font-semibold text-gray-800">{{ $order->user->name }}</span> ({{ $order->user->email }})</p>
            <p>Status: <span class="font-semibold capitalize text-gray-800">{{ $order->status->value }}</span></p>
            <p>Date: <span class="font-semibold text-gray-800">{{ $order->created_at->format('M d, Y H:i') }}</span></p>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="pb-3">Product</th>
                    <th class="pb-3 text-center">Qty</th>
                    <th class="pb-3 text-right">Unit Price</th>
                    <th class="pb-3 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="border-b">
                        <td class="py-3">{{ $item->product->name }}</td>
                        <td class="py-3 text-center">{{ $item->quantity }}</td>
                        <td class="py-3 text-right">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="py-3 text-right">${{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="pt-4 font-semibold">Order Total</td>
                    <td class="pt-4 text-right font-semibold">${{ number_format($order->total_price, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        @if(!$order->isRefunded())
            <div class="mt-6 flex justify-end">
                <form action="{{ route('admin.orders.refund', $order) }}" method="POST">
                    @csrf
                    <button class="bg-red-600 text-white text-sm rounded px-6 py-2 hover:bg-red-500">
                        Refund Order
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
