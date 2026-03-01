<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4">

        @if(session('success'))
            <p class="mb-6 text-green-600">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p class="mb-6 text-red-600">{{ session('error') }}</p>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="border rounded p-4 flex flex-col gap-3">
                    <div>
                        <p class="font-semibold">{{ $product->name }}</p>
                        <p class="text-gray-500">${{ number_format($product->price, 2) }}</p>
                    </div>

                    @auth
                        @if($product->stock_quantity > 0)
                            <form action="{{ route('cart.items.store', $product) }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-14 border rounded px-2 text-sm">
                                <button class="flex-1 bg-gray-800 text-white text-sm rounded px-3 py-1 hover:bg-gray-700">Add to cart</button>
                            </form>
                        @else
                            <p class="text-sm text-red-500">Out of stock</p>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 underline">Login to buy</a>
                    @endauth
                </div>
            @empty
                <p class="col-span-full text-gray-500">No products available.</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $products->links() }}</div>
    </div>
</x-app-layout>
