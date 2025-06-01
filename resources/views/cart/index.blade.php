{{-- resources/views/cart/index.blade.php --}}
<x-app-layout>
  <div class="max-w-6xl mx-auto px-8 py-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Your Shopping Cart</h1>

    {{-- Flash messages --}}
    @if(session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

    @if($cartItems->isEmpty())
      <p class="text-gray-600">Your cart is empty.</p>
    @else
      <div class="overflow-x-auto bg-white rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-base">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-8 py-5 text-left font-medium text-gray-500 uppercase">Product</th>
              <th class="px-8 py-5 text-right font-medium text-gray-500 uppercase">Price</th>
              <th class="px-8 py-5 text-center font-medium text-gray-500 uppercase">Quantity</th>
              <th class="px-8 py-5 text-right font-medium text-gray-500 uppercase">Subtotal</th>
              <th class="px-8 py-5 text-center font-medium text-gray-500 uppercase">Action</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($cartItems as $item)
              @php
                $prod = $item['product'];
                $price = $prod->price;
                $qty = $item['quantity'];
                $subtotal = $price * $qty;
              @endphp
              <tr data-product-id="{{ $prod->id }}" data-price="{{ $price }}" class="hover:bg-gray-50">
                <td class="px-8 py-5 flex items-center space-x-4">
                  @if($prod->image)
                    <img src="{{ asset('storage/'.$prod->image) }}"
                         alt="{{ $prod->name }}"
                         class="h-16 w-16 object-cover rounded-md" />
                  @else
                    <div class="h-16 w-16 bg-gray-100 flex items-center justify-center rounded-md">
                      <span class="text-gray-400 text-xs">No Image</span>
                    </div>
                  @endif
                  <span class="text-gray-800">{{ $prod->name }}</span>
                </td>
                <td class="px-8 py-5 text-right text-gray-700">
                  Rs {{ number_format($price, 2) }}
                </td>
                <td class="px-8 py-5 text-center">
                  <div class="inline-flex items-center border border-gray-200 rounded-md overflow-hidden">
                    <button 
                      class="btn-decrease px-3 py-1 bg-gray-100 hover:bg-gray-200 disabled:opacity-50"
                      @if($qty <= 1) disabled @endif
                    >&minus;</button>
                    <span class="qty-display w-12 text-center text-gray-700">{{ $qty }}</span>
                    <button class="btn-increase px-3 py-1 bg-gray-100 hover:bg-gray-200">&plus;</button>
                  </div>
                </td>
                <td class="px-8 py-5 text-right font-medium text-gray-900">
                  <span class="subtotal">Rs {{ number_format($subtotal, 2) }}</span>
                </td>
                <td class="px-8 py-5 text-center">
                  <button class="btn-remove px-3 py-1 text-red-600 border border-red-600 rounded text-xs hover:bg-red-50 transition">
                    Remove
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot class="bg-gray-50">
            <tr>
              <td colspan="3" class="px-8 py-5 text-right font-semibold text-gray-800">Total:</td>
              <td class="px-8 py-5 text-right font-semibold text-black">
                <span id="cart-total">Rs {{ number_format($total, 2) }}</span>
              </td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="mt-6 flex justify-end space-x-4">
        <a href="{{ route('dashboard') }}"
           class="px-6 py-3 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-100 transition">
          Continue Shopping
        </a>
        <a href="{{ route('checkout') }}"
           class="px-6 py-3 bg-black text-white text-sm font-medium rounded hover:bg-orange-500 transition-colors duration-200">
          Proceed to Checkout
        </a>
      </div>
    @endif
  </div>

  {{-- Inline JavaScript for AJAX update --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Utility: recalculate total by summing all subtotals
      function recalcTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(span => {
          const text = span.textContent.replace('Rs', '').trim().replace(/,/g, '');
          total += parseFloat(text);
        });
        document.getElementById('cart-total').textContent = 'Rs ' + total.toFixed(2);
      }

      // Handle increase button
      document.querySelectorAll('.btn-increase').forEach(btn => {
        btn.addEventListener('click', function () {
          const row = btn.closest('tr');
          const productId = row.dataset.productId;
          const price = parseFloat(row.dataset.price);
          let qtySpan = row.querySelector('.qty-display');
          let qty = parseInt(qtySpan.textContent);
          const newQty = qty + 1;

          // Update UI immediately
          qtySpan.textContent = newQty;
          row.querySelector('.btn-decrease').disabled = false;
          const newSubtotal = price * newQty;
          row.querySelector('.subtotal').textContent = 'Rs ' + newSubtotal.toFixed(2);
          recalcTotal();

          // Send AJAX to backend
          fetch(`/cart/${productId}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ quantity: newQty })
          }).catch(() => {
            alert('Failed to update cart on server.');
          });
        });
      });

      // Handle decrease button
      document.querySelectorAll('.btn-decrease').forEach(btn => {
        btn.addEventListener('click', function () {
          const row = btn.closest('tr');
          const productId = row.dataset.productId;
          const price = parseFloat(row.dataset.price);
          let qtySpan = row.querySelector('.qty-display');
          let qty = parseInt(qtySpan.textContent);
          const newQty = qty - 1;

          if (newQty <= 0) {
            // Remove row
            row.remove();
          } else {
            qtySpan.textContent = newQty;
            row.querySelector('.btn-decrease').disabled = newQty <= 1;
            const newSubtotal = price * newQty;
            row.querySelector('.subtotal').textContent = 'Rs ' + newSubtotal.toFixed(2);
          }
          recalcTotal();

          // Send AJAX or delete if zero
          const method = newQty <= 0 ? 'DELETE' : 'PUT';
          const bodyData = newQty > 0 ? { quantity: newQty } : {};
          fetch(`/cart/${productId}`, {
            method: method,
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(bodyData)
          }).catch(() => {
            alert('Failed to update cart on server.');
          });
        });
      });

      // Handle remove button
      document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', function () {
          if (!confirm('Remove this item?')) return;
          const row = btn.closest('tr');
          const productId = row.dataset.productId;

          // Remove from UI
          row.remove();
          recalcTotal();

          // Send AJAX delete
          fetch(`/cart/${productId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': csrfToken
            }
          }).catch(() => {
            alert('Failed to remove item from server.');
          });
        });
      });
    });
  </script>
</x-app-layout>
