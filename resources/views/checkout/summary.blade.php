{{-- checkout/summary.blade.php --}}

@if(!empty($cartItems) && count($cartItems) > 0)
  <div class="bg-white shadow-lg rounded-xl p-6 max-w-5xl mx-auto"> {{-- max width increased --}}
    <table class="w-full text-sm text-left text-gray-700">
      <thead class="text-xs text-gray-500 uppercase border-b">
        <tr>
          <th class="pb-3" style="width: 45%;">Product</th> {{-- wider product column --}}
          <th class="pb-3 text-center" style="width: 15%;">Quantity</th>
          <th class="pb-3 text-right whitespace-nowrap" style="width: 20%;">Price</th>
          <th class="pb-3 text-right whitespace-nowrap" style="width: 20%;">Total</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @php $grandTotal = 0; @endphp
        @foreach($cartItems as $item)
          @php
            $product = is_array($item) ? $item['product'] : $item->product;
            $quantity = is_array($item) ? $item['quantity'] : $item->quantity;
            $price = $product->price;
            $subtotal = $price * $quantity;
            $grandTotal += $subtotal;
          @endphp
          <tr class="hover:bg-gray-50">
            <td class="py-2 font-medium">{{ $product->name }}</td>
            <td class="py-2 text-center">{{ $quantity }}</td>
            <td class="py-2 text-right whitespace-nowrap">Rs. {{ number_format($price, 2) }}</td>
            <td class="py-2 text-right font-semibold whitespace-nowrap">Rs. {{ number_format($subtotal, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="border-t">
        <tr>
          <td colspan="3" class="pt-4 text-right text-base font-bold text-gray-900">Grand Total:</td>
          <td class="pt-4 text-right text-base font-bold text-black whitespace-nowrap">Rs. {{ number_format($grandTotal, 2) }}</td>
        </tr>
      </tfoot>
    </table>
  </div>
@else
  <p class="text-center text-gray-500">Your cart is empty.</p>
@endif
