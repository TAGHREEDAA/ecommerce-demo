<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <img src="https://placehold.co/400x200/e0e7ff/6366f1?text={{ urlencode($product->name) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-36 object-cover">

                    <div class="p-4 flex flex-col gap-3 flex-1">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                            <p class="text-indigo-600 font-medium mt-0.5">${{ number_format($product->price, 2) }}</p>
                        </div>

                        @if($product->stock_quantity > 0)
                            <span class="text-xs text-green-700 bg-green-50 border border-green-200 rounded-full px-2 py-0.5 w-fit">
                                {{ $product->stock_quantity }} in stock
                            </span>
                        @else
                            <span class="text-xs text-red-700 bg-red-50 border border-red-200 rounded-full px-2 py-0.5 w-fit">
                                Out of stock
                            </span>
                        @endif

                        <div class="mt-auto">
                            @auth
                                @if($product->stock_quantity > 0)
                                    @php
                                        $inCart    = auth()->user()->cart?->items()->where('product_id', $product->id)->value('quantity') ?? 0;
                                        $remaining = $product->stock_quantity - $inCart;
                                    @endphp
                                    @if($remaining > 0)
                                        <form action="{{ route('cart.items.store', $product) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $remaining }}"
                                                   class="w-14 border border-gray-200 rounded-lg px-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                            <button class="flex-1 bg-indigo-600 text-white text-sm rounded-lg px-3 py-1.5 hover:bg-indigo-700 transition">
                                                Add to cart
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full bg-gray-100 text-gray-400 text-sm rounded-lg px-3 py-1.5 cursor-not-allowed">
                                            Added to cart
                                        </button>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-indigo-600 underline">Login to buy</a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-gray-500">No products available.</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $products->links() }}</div>
    </div>
</x-app-layout>
