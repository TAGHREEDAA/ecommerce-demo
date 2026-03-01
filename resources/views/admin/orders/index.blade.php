<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Orders</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-4">

        @if(session('success'))
            <p class="mb-6 text-green-600">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p class="mb-6 text-red-600">{{ session('error') }}</p>
        @endif

        @if($orders->isEmpty())
            <p class="text-gray-500">No orders yet.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="pb-3">Order</th>
                        <th class="pb-3">Customer</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Total</th>
                        <th class="pb-3 text-right">Date</th>
                        <th class="pb-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b">
                            <td class="py-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="underline hover:text-gray-600">#{{ $order->id }}</a>
                            </td>
                            <td class="py-3">{{ $order->user->name }}</td>
                            <td class="py-3 capitalize">{{ $order->status->value }}</td>
                            <td class="py-3 text-right">${{ number_format($order->total_price, 2) }}</td>
                            <td class="py-3 text-right">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="py-3 text-right">
                                @if(!$order->isRefunded())
                                    <form action="{{ route('admin.orders.refund', $order) }}" method="POST">
                                        @csrf
                                        <button class="text-red-600 hover:underline text-xs">Refund</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">Refunded</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
