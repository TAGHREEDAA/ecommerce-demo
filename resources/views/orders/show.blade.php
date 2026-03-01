<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order Confirmation</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        @if(session('success'))
            <p class="mb-6 text-green-600">{{ session('success') }}</p>
        @endif

        <div class="mb-6 text-sm text-gray-600">
            <p>Order <span class="font-semibold">#{{ $order->id }}</span></p>
            <p>Status: <span class="font-semibold capitalize">{{ $order->status->value }}</span></p>
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

        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 underline">Continue shopping</a>
        </div>
    </div>
</x-app-layout>
