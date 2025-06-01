<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Reviews</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="max-w-6xl mx-auto px-6 py-10">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-extrabold text-gray-900">Product Reviews</h1>
    <a href="{{ route('admin.dashboard') }}"
       class="border border-black px-4 py-2 text-sm font-semibold rounded hover:bg-black hover:text-white transition">
      Back to Dashboard
    </a>
  </div>

  {{-- Session message --}}
  @if(session('success'))
    <div class="mb-6 px-4 py-3 rounded-md bg-green-50 border border-green-200 text-green-800 font-medium shadow-sm">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto bg-white rounded-lg shadow-md">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-50 text-xs uppercase text-gray-600 font-bold">
        <tr>
          <th class="px-6 py-3 text-left">Product</th>
          <th class="px-6 py-3 text-left">User</th>
          <th class="px-6 py-3 text-left">Rating</th>
          <th class="px-6 py-3 text-left">Comment</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100 font-medium">
        @forelse($reviews as $r)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-gray-800">{{ App\Models\Product::find($r->product_id)->name ?? '—' }}</td>
            <td class="px-6 py-4 text-gray-800">{{ App\Models\User::find($r->user_id)->name ?? '—' }}</td>
            <td class="px-6 py-4 text-yellow-500">
              @for($i=0; $i < $r->rating; $i++)
                <svg class="inline-block h-4 w-4 fill-current" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.97c.3.92-.755 1.688-1.54 1.118L10 13.347l-3.385 2.46c-.784.57-1.838-.197-1.539-1.118l1.286-3.97a1 1 0 00-.364-1.118L2.612 9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z"/>
                </svg>
              @endfor
            </td>
            <td class="px-6 py-4 text-gray-700">{{ \Illuminate\Support\Str::limit($r->comment, 50) }}</td>
            <td class="px-6 py-4 text-center">
              <form action="{{ route('admin.reviews.destroy', $r->_id) }}" method="POST" class="inline-block"
                    onsubmit="return confirm('Are you sure you want to delete this review?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="border border-red-600 px-3 py-1 rounded hover:bg-red-600 hover:text-white text-red-600 font-semibold transition">
                  Delete
                </button>
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
  <div class="mt-6">
    {{ $reviews->links() }}
  </div>
</div>

</body>
</html>
