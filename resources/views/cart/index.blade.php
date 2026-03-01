<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Cart</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        @if(session('success'))
            <p class="mb-6 text-green-600">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p class="mb-6 text-red-600">{{ session('error') }}</p>
        @endif

        @if($errors->any())
            <ul class="mb-6 text-red-600 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @if($cartItems->isEmpty())
            <p class="text-gray-500">Your cart is empty. <a href="{{ route('dashboard') }}" class="underline">Browse products</a></p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="pb-3">Product</th>
                        <th class="pb-3 text-center">Qty</th>
                        <th class="pb-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr class="border-b">
                            <td class="py-3">{{ $item->product->name }}</td>
                            <td class="py-3 text-center">{{ $item->quantity }}</td>
                            <td class="py-3 text-right">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="pt-4 font-semibold">Total</td>
                        <td class="pt-4 text-right font-semibold">${{ number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-6 flex justify-end">
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <button class="bg-gray-800 text-white text-sm rounded px-6 py-2 hover:bg-gray-700">
                        Place Order — Cash on Delivery
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
