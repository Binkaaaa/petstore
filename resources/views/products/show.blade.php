{{-- resources/views/products/show.blade.php --}}
<x-app-layout>
  <div class="max-w-4xl mx-auto px-6 py-8">
    
    {{-- Breadcrumbs --}}
    <nav class="text-sm text-gray-500 mb-6">
      <a href="{{ route('dashboard') }}" class="hover:underline">Home</a>
      <span class="mx-2">/</span>
      <span class="font-semibold text-gray-700">{{ $product->name }}</span>
    </nav>

    {{-- Two-Column Layout --}}
    <div class="lg:flex lg:space-x-10">
      
      {{-- Left: Product Image --}}
      <div class="flex-shrink-0 mb-6 lg:mb-0">
        @if($product->image)
          <img 
            src="{{ asset('storage/'.$product->image) }}" 
            alt="{{ $product->name }}" 
            class="w-full lg:w-80 h-auto rounded-lg border border-gray-200 shadow-sm object-contain"
          >
        @else
          <div class="w-full lg:w-80 h-80 bg-gray-100 flex items-center justify-center rounded-lg border border-gray-200">
            <span class="text-gray-400">No Image Available</span>
          </div>
        @endif
      </div>

      {{-- Right: Details --}}
      <div class="flex-1 flex flex-col justify-between">
        {{-- Top: Name, Description, Rating, Price --}}
        <div>
          <h1 class="text-3xl font-semibold text-gray-900 mb-3">{{ $product->name }}</h1>
          <p class="text-gray-600 mb-5 leading-relaxed">{{ $product->description }}</p>

          {{-- ★★★★★ Average Rating --}}
          <div class="flex items-center mb-6">
            @php
              $avg = $product->reviews->count() > 0 
                ? round($product->reviews->avg('rating'), 1)
                : 0;
              $count = $product->reviews->count();
            @endphp
            <div class="flex space-x-1 text-yellow-400">
              @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($avg))
                  <svg class="h-4 w-4 fill-current"><use href="#icon-star-full"/></svg>
                @elseif($i - $avg < 1)
                  <svg class="h-4 w-4 fill-current"><use href="#icon-star-half"/></svg>
                @else
                  <svg class="h-4 w-4 stroke-current"><use href="#icon-star-empty"/></svg>
                @endif
              @endfor
            </div>
            <span class="ml-2 text-sm text-gray-500">({{ $count }} reviews, avg {{ $avg }})</span>
          </div>

          {{-- Price --}}
          <div class="text-2xl font-bold text-gray-900 mb-6">
            Rs {{ number_format($product->price, 2) }}
          </div>

          {{-- Stock Info --}}
          <div class="text-gray-700 mb-4">
            @if($product->stock > 0)
              <span class="inline-block px-2 py-1 bg-green-100 text-green-700 rounded-full text-sm">In Stock</span>
            @else
              <span class="inline-block px-2 py-1 bg-red-100 text-red-700 rounded-full text-sm">Out of Stock</span>
            @endif
          </div>

          {{-- Add to Cart Form --}}
          <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center space-x-3">
            @csrf
            <label for="quantity" class="text-gray-700">Qty:</label>
            <input 
              type="number" 
              name="quantity" 
              id="quantity" 
              value="1" 
              min="1" 
              max="{{ $product->stock }}" 
              class="w-16 border border-gray-300 rounded text-center py-1"
              @if($product->stock == 0) disabled @endif
            >
            <button 
              type="submit"
              @if($product->stock == 0) disabled @endif
              class="px-5 py-2 bg-black text-white text-sm font-medium rounded hover:bg-orange-500 transition-colors duration-200 disabled:opacity-50"
            >
              Add to Cart
            </button>
          </form>
        </div>

        {{-- Bottom: Review Section --}}
        <div>
          @auth
            {{-- Leave a Review --}}
            <div class="mt-8 bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
              <h2 class="text-lg font-medium mb-3">Leave a Review</h2>
              <div id="star-widget" class="flex space-x-2 mb-2" data-rating="0">
                @for($i = 1; $i <= 5; $i++)
                  <button 
                    type="button" 
                    data-value="{{ $i }}" 
                    class="star h-5 w-5 text-gray-300 hover:text-yellow-400 focus:outline-none"
                  >
                    <svg viewBox="0 0 20 20" class="fill-current"><use href="#icon-star-full"/></svg>
                  </button>
                @endfor
              </div>
              <textarea 
                id="review-comment" 
                rows="3" 
                placeholder="Your comments..." 
                class="w-full border border-gray-300 rounded p-2 text-gray-700 mb-3"
              ></textarea>
              <button 
                id="submit-review" 
                class="px-4 py-2 bg-black text-white rounded hover:bg-orange-500 transition-colors duration-200 text-sm"
              >
                Submit Review
              </button>
            </div>
          @endauth

          {{-- Existing Reviews --}}
          <div class="mt-8">
            <h2 class="text-lg font-medium mb-4">Customer Reviews</h2>
            @forelse($product->reviews as $review)
              <div class="border-t border-gray-200 pt-4 pb-4">
                <div class="flex items-center mb-1">
                  <span class="font-medium text-gray-800">{{ $review->user_name ?? 'Anonymous' }}</span>
                  <span class="ml-3 text-yellow-400">
                    @for($i = 0; $i < $review->rating; $i++)
                      <svg class="inline-block h-4 w-4 fill-current"><use href="#icon-star-full"/></svg>
                    @endfor
                  </span>
                </div>
                <p class="text-gray-700 text-sm whitespace-pre-line">{{ $review->comment }}</p>
              </div>
            @empty
              <p class="text-gray-500 text-sm">No reviews yet. Be the first to review!</p>
            @endforelse
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- SVG Icons --}}
  <svg style="display: none;">
    <symbol id="icon-star-full" viewBox="0 0 20 20">
      <path d="M10 15l-5.878 3.09L5.64 11.545 1 7.455l6.061-.545L10 2l2.939 4.91 6.061.545-4.64 4.09 1.518 6.545z" />
    </symbol>
    <symbol id="icon-star-half" viewBox="0 0 20 20">
      <path d="M10 15l-5.878 3.09L5.64 11.545 1 7.455l6.061-.545L10 2z" />
    </symbol>
    <symbol id="icon-star-empty" viewBox="0 0 20 20">
      <path 
        d="M10 15l-5.878 3.09L5.64 11.545 1 7.455l6.061-.545L10 2l2.939 4.91 6.061.545-4.64 4.09 1.518 6.545z" 
        fill="none" stroke="currentColor" stroke-width="1.5"
      />
    </symbol>
  </svg>

  {{-- JS for Star Rating & AJAX --}}
  @auth
<script>
document.addEventListener('DOMContentLoaded', () => {
  // 1) Grab CSRF cookie
  fetch('/sanctum/csrf-cookie', { credentials: 'include' })
    .then(() => {
      console.log('✅ CSRF cookie set');
      initReviewForm();
    })
    .catch(err => {
      console.error('❌ Failed to get CSRF cookie:', err);
      alert('Could not initialize review form. See console for details.');
    });
});

function initReviewForm() {
  // star-widget setup (unchanged)…
  document.querySelectorAll('#star-widget .star').forEach((star, i) => {
    star.addEventListener('click', () => {
      const rating = i + 1;
      document.querySelector('#star-widget').dataset.rating = rating;
      document.querySelectorAll('#star-widget .star').forEach((s, idx) => {
        s.classList.toggle('text-yellow-400', idx < rating);
        s.classList.toggle('text-gray-300', idx >= rating);
      });
    });
  });

  // submit handler
  document.getElementById('submit-review').addEventListener('click', async (e) => {
    e.preventDefault();

    const productId = "{{ $product->id }}";
    const rating   = document.querySelector('#star-widget').dataset.rating || 0;
    const comment  = document.getElementById('review-comment').value;
    fetch('/reviews', {
      method: 'POST',
      credentials: 'same-origin',          // include cookies on same-domain
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ product_id: productId, rating, comment })
    })
    try {
      const res = await fetch('/api/reviews', {
        method: 'POST',
        credentials: 'include',
        headers: {
          'Content-Type': 'application/json',
          'Accept':       'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, rating, comment })
      });

      // Check HTTP status
      if (!res.ok) {
        const errJson = await res.json().catch(() => ({}));
        console.error('Server responded with error:', res.status, errJson);
        alert('Failed to submit review: ' + (errJson.message || res.statusText));
        return;
      }

      const data = await res.json();
      if (data.success) {
        alert('🎉 Review submitted successfully!');
        location.reload();
      } else {
        console.warn('Validation or saving failed:', data);
        alert('Failed to submit review: ' + (data.message || 'Unknown error'));
      }
    } catch (networkError) {
      console.error('Network or parsing error:', networkError);
      alert('An error occurred while submitting your review. Check console for details.');
    }
  });
}
</script>
@endauth

</x-app-layout>
