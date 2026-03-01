<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Orders</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        @if($orders->isEmpty())
            <p class="text-gray-500">You have no orders yet. <a href="{{ route('dashboard') }}" class="underline">Browse products</a></p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="pb-3">Order</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Total</th>
                        <th class="pb-3 text-right">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b">
                            <td class="py-3">
                                <a href="{{ route('orders.show', $order) }}" class="underline">#{{ $order->id }}</a>
                            </td>
                            <td class="py-3 capitalize">{{ $order->status->value }}</td>
                            <td class="py-3 text-right">${{ number_format($order->total_price, 2) }}</td>
                            <td class="py-3 text-right">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
