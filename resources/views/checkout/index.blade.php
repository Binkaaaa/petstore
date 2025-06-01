{{-- resources/views/checkout/index.blade.php --}}
<x-app-layout>
  <div class="container mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST" onsubmit="return handleOrderConfirm(event)">
      @csrf

      {{-- Order Type Selection --}}
      <fieldset class="mb-6">
        <legend class="text-lg font-semibold text-gray-700">Select Delivery Option</legend>
        <div class="mt-4 space-y-4">
          <label class="flex items-center space-x-3">
            <input type="radio" name="order_type" value="pickup" checked class="form-radio h-5 w-5 text-indigo-600">
            <span class="text-gray-700">Store Pickup (Pay Online)</span>
          </label>
          <label class="flex items-center space-x-3">
            <input type="radio" name="order_type" value="delivery" class="form-radio h-5 w-5 text-indigo-600">
            <span class="text-gray-700">Home Delivery (Cash on Delivery)</span>
          </label>
        </div>
      </fieldset>

      {{-- Delivery Address --}}
      <div id="delivery-fields" class="mb-6 hidden">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Delivery Address</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" name="delivery_address" placeholder="Address"
                 class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
          <input type="text" name="delivery_city" placeholder="City"
                 class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
          <input type="text" name="delivery_postcode" placeholder="Postcode"
                 class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
          <input type="tel" name="delivery_phone" placeholder="Phone Number"
                 class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
        </div>
      </div>

      {{-- Payment Info --}}
      <div id="payment-fields" class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Payment</h3>
        <p class="text-gray-600">You will be redirected to our secure payment gateway after clicking "Place Order".</p>
      </div>

      {{-- Order Summary --}}
      <div class="mb-6">
        @include('checkout.summary') {{-- Make sure this file doesn't include checkout.index --}}
      </div>

      <button type="submit"
              class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
        Place Order
      </button>
    </form>
  </div>

  {{-- JavaScript --}}
  <script>
    document.querySelectorAll('input[name="order_type"]').forEach(el => {
      el.addEventListener('change', function () {
        const isDelivery = this.value === 'delivery';
        document.getElementById('delivery-fields').classList.toggle('hidden', !isDelivery);
        document.getElementById('payment-fields').classList.toggle('hidden', isDelivery);
      });
    });

    function handleOrderConfirm(e) {
      const confirmed = confirm('Are you sure you want to place this order?\n\nOK to place order, Cancel to continue shopping.');
      if (!confirmed) {
        e.preventDefault();
        window.location.href = "{{ route('dashboard') }}";
      }
      return confirmed;
    }
  </script>
</x-app-layout>
