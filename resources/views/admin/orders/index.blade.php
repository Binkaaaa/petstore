{{-- resources/views/admin/orders/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Orders Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <div class="max-w-7xl mx-auto px-6 py-10" x-data="{ showModal: false, currentOrder: null }">
    <h1 class="text-3xl font-bold mb-6">Orders Management</h1>
      <a href="{{ route('admin.dashboard') }}" class="inline-block mb-6 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded hover:bg-indigo-700">
    ← Back to Dashboard
  </a>

    @if(session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Order #</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Customer</th>
            <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase">Total</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Type</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Created</th>
            <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($orders as $order)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-sm">#{{ $order->id }}</td>
            <td class="px-6 py-4 text-sm">{{ $order->user->name }}</td>
            <td class="px-6 py-4 text-sm text-right">Rs {{ number_format($order->total_price,2) }}</td>
            <td class="px-6 py-4 text-sm">{{ ucfirst($order->order_type) }}</td>
            <td class="px-6 py-4 text-sm">{{ ucfirst($order->order_status) }}</td>
            <td class="px-6 py-4 text-sm">{{ $order->created_at->format('Y-m-d') }}</td>
            <td class="px-6 py-4 text-center space-x-2">
              <button 
                class="text-indigo-600 hover:underline font-medium"
                @click="showModal = true; currentOrder = {{ $order->toJson() }}">
                View
              </button>

              <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this order?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-6">
      {{ $orders->links() }}
    </div>

    <!-- Modal -->
    <div 
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
      x-show="showModal"
      x-transition
    >
      <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
        <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-600" @click="showModal = false">
          &times;
        </button>
        <h2 class="text-xl font-bold mb-4">Order Details</h2>
        <template x-if="currentOrder">
          <div class="space-y-2 text-sm">
            <p><strong>Order #:</strong> <span x-text="currentOrder.id"></span></p>
            <p><strong>Customer:</strong> <span x-text="currentOrder.user.name"></span></p>
            <p><strong>Total Price:</strong> Rs <span x-text="Number(currentOrder.total_price).toFixed(2)"></span></p>
            <p><strong>Order Type:</strong> <span x-text="currentOrder.order_type"></span></p>
            <p><strong>Status:</strong> <span x-text="currentOrder.order_status"></span></p>
            <p><strong>Created At:</strong> <span x-text="currentOrder.created_at"></span></p>
          </div>
        </template>
      </div>
    </div>
  </div>

</body>
</html>
