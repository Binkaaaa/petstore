<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Reviews</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto px-6 py-8">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Product Reviews</h1>
    <a href="{{ route('admin.dashboard') }}" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-900 transition">
      Back to Dashboard
    </a>
  </div>

  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
          <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($reviews as $r)
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ App\Models\Product::find($r->product_id)->name ?? '—' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ App\Models\User::find($r->user_id)->name ?? '—' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-500">
            @for($i=0; $i < $r->rating; $i++)
              <svg class="inline-block h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.97c.3.92-.755 1.688-1.54 1.118L10 13.347l-3.385 2.46c-.784.57-1.838-.197-1.539-1.118l1.286-3.97a1 1 0 00-.364-1.118L2.612 9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z"/></svg>
            @endfor
          </td>
          <td class="px-6 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($r->comment, 50) }}</td>
          <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
            <form action="{{ route('admin.reviews.destroy', $r->_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');" class="inline-block">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No reviews found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div class="mt-4">
    {{ $reviews->links() }}
  </div>
</div>

</body>
</html>
