{{-- resources/views/checkout/index.blade.php --}}
<x-app-layout>
  <div class="max-w-5xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST" onsubmit="return handleOrderConfirm(event)" class="space-y-8">
      @csrf

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Left Column: Options & Details --}}
        <div class="space-y-6">
          {{-- Delivery Option --}}
          <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Delivery Option</h2>
            <div class="space-y-4">
              <label class="flex items-center space-x-3">
                <input 
                  type="radio" 
                  name="order_type" 
                  value="pickup" 
                  checked 
                  class="form-radio h-5 w-5 text-orange-500"
                >
                <span class="text-gray-700">Store Pickup (Pay Online)</span>
              </label>
              <label class="flex items-center space-x-3">
                <input 
                  type="radio" 
                  name="order_type" 
                  value="delivery" 
                  class="form-radio h-5 w-5 text-orange-500"
                >
                <span class="text-gray-700">Home Delivery (Cash on Delivery)</span>
              </label>
            </div>
          </div>

          {{-- Store Pickup Info --}}
          <div id="pickup-info" class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Store Pickup Info</h2>
            <p class="text-gray-700">
              Please visit our store at Primrose Street, Kandy to pick up your order. Payment will be processed online at checkout.
            </p>
          </div>

          {{-- Delivery Address (shown only if delivery selected) --}}
          <div id="delivery-fields" class="hidden bg-white p-6 rounded-lg shadow space-y-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Delivery Address</h2>
            <input 
              type="text" 
              name="delivery_address" 
              placeholder="Street Address"
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-300 px-3 py-2 text-gray-700"
              value="{{ old('delivery_address') }}"
            />
            <input 
              type="text" 
              name="delivery_city" 
              placeholder="City"
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-300 px-3 py-2 text-gray-700"
              value="{{ old('delivery_city') }}"
            />
            <input 
              type="text" 
              name="delivery_postcode" 
              placeholder="Postcode"
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-300 px-3 py-2 text-gray-700"
              value="{{ old('delivery_postcode') }}"
            />
            <input 
              type="tel" 
              name="delivery_phone" 
              placeholder="Phone Number"
              class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-300 px-3 py-2 text-gray-700"
              value="{{ old('delivery_phone') }}"
            />
          </div>
        </div>

        {{-- Right Column: Order Summary --}}
        <div>
          <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>
            @include('checkout.summary')
          </div>
        </div>
      </div>

      {{-- Place Order Button --}}
      <button 
        type="submit"
        class="w-full lg:w-auto px-6 py-3 bg-black text-white font-semibold rounded-lg hover:bg-orange-500 transition-colors duration-200"
      >
        Place Order
      </button>
    </form>
  </div>

{{-- Success Flash Message Alert --}}
@if(session('success'))
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      alert("{{ session('success') }}\n\nFor assistance, call: {{ session('phone') ?? '011 1234 5678' }}");
    });
  </script>
@endif

  {{-- JavaScript for toggling fields and confirmation --}}
  <script>
    const orderTypeRadios = document.querySelectorAll('input[name="order_type"]');
    const deliveryFields = document.getElementById('delivery-fields');
    const pickupInfo = document.getElementById('pickup-info');

    orderTypeRadios.forEach(el => {
      el.addEventListener('change', function () {
        if (this.value === 'delivery') {
          deliveryFields.classList.remove('hidden');
          pickupInfo.classList.add('hidden');
        } else {
          deliveryFields.classList.add('hidden');
          pickupInfo.classList.remove('hidden');
        }
      });
    });

    function handleOrderConfirm(e) {
      const confirmed = confirm(
        'Are you sure you want to place this order?\n\n' +
        'OK to place order, Cancel to continue shopping.'
      );
      if (!confirmed) {
        e.preventDefault();
        window.location.href = "{{ route('dashboard') }}";
      }
      return confirmed;
    }

    // On page load, set visibility correctly based on default radio
    window.addEventListener('DOMContentLoaded', () => {
      const checked = document.querySelector('input[name="order_type"]:checked').value;
      if (checked === 'delivery') {
        deliveryFields.classList.remove('hidden');
        pickupInfo.classList.add('hidden');
      } else {
        deliveryFields.classList.add('hidden');
        pickupInfo.classList.remove('hidden');
      }
    });
  </script>
</x-app-layout>
