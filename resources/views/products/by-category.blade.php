<x-app-layout>
    {{-- Hero Banner & Breadcrumb --}}
    <section class="relative bg-black">
        <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
        <div class="max-w-7xl mx-auto px-8 py-20 relative z-10 flex flex-col lg:flex-row items-center">
            <div class="w-full lg:w-2/3 text-white">
                <h1 class="text-5xl font-bold mb-4 text-orange-500">{{ ucfirst($category->name) }}</h1>
                <p class="max-w-3xl mb-6 opacity-80 text-gray-200">
                    Provide your beloved {{ strtolower($category->name) }} with the nourishment they deserve. From premium dry kibble to nutritious wet meals, our collection features only the finest ingredients to keep your pet healthy and happy.
                </p>
                <nav class="flex text-sm text-gray-400">
                    <a href="{{ route('dashboard') }}" class="hover:underline text-orange-400">Home</a>
                    <span class="mx-2">›</span>
                    <span class="font-semibold text-white">{{ ucfirst($category->name) }}</span>
                </nav>
            </div>
            <div class="w-full lg:w-1/3 mt-8 lg:mt-0 flex justify-center">
                @if($category->image)
                    <img src="{{ asset('storage/'.$category->image) }}" 
                         alt="{{ $category->name }}" 
                         class="rounded-xl shadow-2xl w-full max-w-sm">
                @endif
            </div>
        </div>
    </section>

    {{-- Toolbar: Sort & Filter --}}
    <div class="max-w-7xl mx-auto px-8 py-8 flex flex-col md:flex-row items-center justify-between">
        <div class="text-gray-800 mb-4 md:mb-0">
            Showing <span class="font-semibold">{{ $products->count() }}</span> products
        </div>
        <div class="flex space-x-4">
            <select id="sort" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-300">
                <option value="newest">Newest</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
            </select>
        </div>
    </div>

    {{-- Product Grid --}}
    <div class="max-w-7xl mx-auto px-8 pb-16">
        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col overflow-hidden">
                        <a href="{{ route('product.show', $product->id) }}" class="block w-full">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="object-contain w-full h-64 p-4">
                            @else
                                <div class="w-full h-64 bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-400">No Image Available</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-6 flex flex-col flex-1">
                            <h2 class="text-xl font-semibold text-gray-900 hover:text-orange-500 mb-2">
                                <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                            </h2>
                            <p class="text-gray-600 text-sm flex-1 mb-4">
                                {{ Str::limit($product->description, 100) }}
                            </p>

                            {{-- Price --}}
                            <div>
                                <span class="text-lg font-bold text-orange-500">
                                    Rs {{ number_format($product->price, 2) }}
                                </span>
                            </div>

                            {{-- Buttons Grouped Below Price --}}
                            <div class="mt-4 flex space-x-2">
                                {{-- View Button --}}
                                <a href="{{ route('product.show', $product->id) }}"
                                   class="px-4 py-2 border bg-black border-black text-white text-sm font-medium rounded-lg 
                                                   hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-colors duration-200">
                                    View
                                </a>

                                {{-- Add to Cart Button --}}
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="px-4 py-2 border bg-black border-black text-white text-sm font-medium rounded-lg 
                                                   hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-colors duration-200">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-gray-500 text-lg">No products found in this category.</p>
            </div>
        @endif
    </div>
    <!-- Footer Section -->
<footer class="bg-black text-white px-6 py-14">
  <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">

    <!-- About Column -->
    <div>
      <h2 class="text-xl font-extrabold text-white mb-4">PetPaw</h2>
      <p class="text-sm text-gray-300 leading-relaxed">
        Providing premium pet care essentials with love and dedication to keep your furry friends happy and healthy.
      </p>
    </div>

    <!-- Shop Column -->
    <div>
      <h3 class="text-lg font-semibold text-white mb-3">Shop</h3>
      <ul class="space-y-2 text-sm text-gray-300">
        <li><a href="#" class="hover:text-white">Home</a></li>
        <li><a href="#" class="hover:text-white">Category</a></li>
        <li><a href="#" class="hover:text-white">Contact Us</a></li>
      </ul>
    </div>

    <!-- Account Column -->
    <div>
      <h3 class="text-lg font-semibold text-white mb-3">My Account</h3>
      <ul class="space-y-2 text-sm text-gray-300">
        <li><a href="#" class="hover:text-white">Login</a></li>
        <li><a href="#" class="hover:text-white">Logout</a></li>
        <li><a href="#" class="hover:text-white">Cart</a></li>
      </ul>
    </div>

    <!-- Subscribe Column -->
    <div>
      <h3 class="text-lg font-semibold text-white mb-3">Sign Up for Updates</h3>
      <p class="text-sm text-gray-300 mb-4">Get the latest news about our products and promotions.</p>
      <form class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3">
        <input type="email" placeholder="Your email address"
          class="w-full sm:w-auto px-4 py-2 rounded-md bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white" />
        <button type="submit"
          class="px-4 py-2 rounded-md bg-white text-black font-semibold hover:bg-gray-200 transition">
          Subscribe
        </button>
      </form>
    </div>

  </div>

  <!-- Divider -->
  <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-400">
    © 2025 PetPaw. All Rights Reserved.
  </div>
</footer>
</x-app-layout>
