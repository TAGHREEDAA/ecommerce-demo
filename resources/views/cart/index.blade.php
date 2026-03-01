<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Cart</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">
                Your cart is empty. <a href="{{ route('dashboard') }}" class="text-indigo-600 underline">Browse products</a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-left">
                            <th class="px-6 py-3 text-gray-500 font-medium">Product</th>
                            <th class="px-6 py-3 text-gray-500 font-medium text-center">Qty</th>
                            <th class="px-6 py-3 text-gray-500 font-medium text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="px-6 py-4 text-gray-800">{{ $item->product->name }}</td>
                                <td class="px-6 py-4 text-center text-gray-600">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-right text-gray-800 font-medium">${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t border-gray-100">
                        <tr>
                            <td colspan="2" class="px-6 py-4 font-semibold text-gray-800">Total</td>
                            <td class="px-6 py-4 text-right font-semibold text-indigo-600 text-base">${{ number_format($total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 flex justify-end">
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <button class="bg-indigo-600 text-white text-sm rounded-lg px-6 py-2.5 hover:bg-indigo-700 transition font-medium">
                        Place Order — Cash on Delivery
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
