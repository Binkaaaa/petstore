<div class="bg-white shadow rounded-lg p-6">
  @if(count($cartItems) > 0)
    <table class="w-full text-left">
      <thead>
        <tr>
          <th class="pb-3 text-gray-700">Product</th>
          <th class="pb-3 text-gray-700">Quantity</th>
          <th class="pb-3 text-gray-700">Price</th>
          <th class="pb-3 text-gray-700">Total</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @php $grandTotal = 0; @endphp
        @foreach($cartItems as $item)
          @php $total = $item->product->price * $item->quantity; $grandTotal += $total; @endphp
          <tr>
            <td class="py-2">{{ $item->product->name }}</td>
            <td class="py-2">{{ $item->quantity }}</td>
            <td class="py-2">Rs. {{ number_format($item->product->price, 2) }}</td>
            <td class="py-2">Rs. {{ number_format($total, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" class="pt-4 text-right font-semibold text-lg text-gray-800">Grand Total:</td>
          <td class="pt-4 font-semibold text-lg text-gray-800">Rs. {{ number_format($grandTotal, 2) }}</td>
        </tr>
      </tfoot>
    </table>
  @else

  @endif
</div>
