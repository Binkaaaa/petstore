{{-- resources/views/cart/index.blade.php --}}
<x-app-layout>
  <div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-6">Your Shopping Cart</h1>

    {{-- Flash messages --}}
    @if(session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif

    @if($cartItems->isEmpty())
      <p class="text-gray-600">Your cart is empty.</p>
    @else
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Product</th>
              <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase">Price</th>
              <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">Quantity</th>
              <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase">Subtotal</th>
              <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">Action</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($cartItems as $item)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 flex items-center space-x-4">
                  @if($item['product']->image)
                    <img src="{{ asset('storage/'.$item['product']->image) }}"
                         alt="{{ $item['product']->name }}"
                         class="h-16 w-16 object-cover rounded" />
                  @else
                    <div class="h-16 w-16 bg-gray-100 flex items-center justify-center rounded">
                      <span class="text-gray-400 text-sm">No Image</span>
                    </div>
                  @endif
                  <span class="text-gray-800">{{ $item['product']->name }}</span>
                </td>
                <td class="px-6 py-4 text-right text-gray-700">
                  Rs {{ number_format($item['product']->price, 2) }}
                </td>
                <td class="px-6 py-4 text-center text-gray-700">
                  {{ $item['quantity'] }}
                </td>
                <td class="px-6 py-4 text-right font-semibold text-gray-900">
                  Rs {{ number_format($item['subtotal'], 2) }}
                </td>
                <td class="px-6 py-4 text-center">
                  <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this product?');">
                    @csrf
                    <button type="submit"
                            class="text-red-600 hover:underline text-sm">
                      Remove
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot class="bg-gray-50">
            <tr>
              <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-800">Total:</td>
              <td class="px-6 py-4 text-right font-bold text-indigo-600">
                Rs {{ number_format($total, 2) }}
              </td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="mt-6 flex justify-end space-x-4">
        <a href="{{ route('dashboard') }}"
           class="px-6 py-3 border border-gray-300 text-gray-700 rounded hover:bg-gray-100 transition">
          Continue Shopping
        </a>
<a href="{{ route('checkout') }}"
   class="px-6 py-3 bg-black text-white font-semibold rounded-lg border border-black transition duration-300 ease-in-out">
  Proceed to Checkout
</a>

    @endif
  </div>
</x-app-layout>
