<x-app-layout>
    {{-- Hero Banner & Breadcrumb --}}
    <section class="relative bg-indigo-600">
        <div class="absolute inset-0 bg-black opacity-25"></div>
        <div class="container mx-auto px-6 py-16 relative z-10 flex flex-col lg:flex-row items-center">
            <div class="w-full lg:w-2/3 text-white">
                <h1 class="text-4xl font-extrabold mb-4">{{ ucfirst($category->name) }}</h1>
                <p class="max-w-2xl mb-6 opacity-90">
                    Provide your beloved {{ strtolower($category->name) }} with the nourishment they deserve. From premium dry kibble to nutritious wet meals, our collection features only the finest ingredients to keep your pet healthy and happy.
                </p>
                <nav class="flex text-sm opacity-75">
                    <a href="{{ route('dashboard') }}" class="hover:underline text-indigo-200">Home</a>
                    <span class="mx-2">›</span>
                    <span class="font-semibold">{{ ucfirst($category->name) }}</span>
                </nav>
            </div>
            <div class="w-full lg:w-1/3 mt-8 lg:mt-0">
                @if($category->image)
                    <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" class="rounded-lg shadow-xl">
                @endif
            </div>
        </div>
    </section>

    {{-- Toolbar: Sort & Filter --}}
    <div class="container mx-auto px-6 py-6 flex flex-col md:flex-row items-center justify-between">
        <div class="text-gray-700 mb-4 md:mb-0">
            Showing <span class="font-semibold">{{ $products->count() }}</span> products
        </div>
        <div class="flex space-x-4">
            <select id="sort" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-indigo-300">
                <option value="newest">Newest</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
            </select>
        </div>
    </div>

    {{-- Product Grid --}}
    <div class="container mx-auto px-6 pb-12">
        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col overflow-hidden">
                        <a href="{{ route('product.show', $product->id) }}" class="block h-56 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full transform hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-400">No Image Available</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-6 flex flex-col flex-1">
                            <h2 class="text-lg font-semibold text-gray-900 hover:text-indigo-600 truncate">
                                <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                            </h2>
                            <p class="mt-2 text-gray-600 text-sm flex-1">{{ Str::limit($product->description, 80) }}</p>
                            <div class="mt-4 flex items-center justify-between space-x-2">
                                <span class="text-xl font-bold text-indigo-600">${{ number_format($product->price,2) }}</span>
                                <a href="{{ route('product.show', $product->id) }}"
                                   class="px-4 py-2 border border-indigo-600 text-indigo-600 text-sm font-medium rounded-lg hover:bg-indigo-50 transition-colors duration-200">
                                    View Product
                                </a>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                       class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-gray-500 text-lg">No products found in this category.</p>
            </div>
        @endif
    </div>
</x-app-layout>
