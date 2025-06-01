<x-app-layout>
  <div class="flex flex-col items-center justify-center min-h-[70vh] px-4">
    <!-- Success Icon -->
    <div class="bg-green-100 rounded-full p-5 mb-6">
      <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
    </div>

    <!-- Message -->
    <h1 class="text-3xl font-bold text-green-700 mb-2">Order Placed Successfully!</h1>
    <p class="text-gray-600 text-lg mb-6 text-center">
      Thank you for shopping with us. Your order has been placed and is being processed.
    </p>

    <!-- Loading Spinner & Redirect Note -->
    <div class="flex items-center space-x-2 mb-4">
      <svg class="animate-spin h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
      </svg>
      <span class="text-gray-500">Redirecting to your dashboard...</span>
    </div>

    <!-- Fallback Button -->
    <a href="{{ route('dashboard') }}"
       class="text-sm text-green-700 hover:underline">
      Go now
    </a>
  </div>

  <!-- JS: Show alert, then redirect -->
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      alert("{{ session('success') }}\n\nFor assistance, call: {{ session('phone') ?? '011 1234 5678' }}");
      setTimeout(() => {
        window.location.href = "{{ route('dashboard') }}";
      }, 3000); // Delay for 3 seconds after alert
    });
  </script>
</x-app-layout>
