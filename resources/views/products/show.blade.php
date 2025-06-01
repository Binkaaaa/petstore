{{-- resources/views/products/show.blade.php --}}
<x-app-layout>
  <div class="container mx-auto px-6 py-10">
    {{-- Breadcrumbs (unchanged) --}}
    <nav class="text-sm text-gray-600 mb-6">
      <!-- Your breadcrumbs here -->
    </nav>

    <div class="lg:grid lg:grid-cols-2 lg:gap-12">
      {{-- Left: Image Gallery (unchanged) --}}
      <div class="space-y-4">
        {{-- Put your product images here --}}
        <!-- ... -->
      </div>

      {{-- Right: Details --}}
      <div class="mt-8 lg:mt-0 flex flex-col justify-between">
        <div>
          <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $product->name }}</h1>
          <p class="text-lg text-gray-700 mb-6">{{ $product->description }}</p>

          {{-- ★★★★★ Average Rating --}}
          <div class="flex items-center mb-4">
            @php
              $avg = $product->reviews->count() > 0 
                ? round($product->reviews->avg('rating'), 1)
                : 0;
              $count = $product->reviews->count();
            @endphp
            <div class="flex text-yellow-400">
              @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($avg))
                  <svg class="h-5 w-5 fill-current"><use href="#icon-star-full"/></svg>
                @elseif($i - $avg < 1)
                  <svg class="h-5 w-5 fill-current"><use href="#icon-star-half"/></svg>
                @else
                  <svg class="h-5 w-5 stroke-current"><use href="#icon-star-empty"/></svg>
                @endif
              @endfor
            </div>
            <span class="ml-3 text-gray-600">({{ $count }} reviews, avg {{ $avg }})</span>
          </div>

          <div class="text-3xl font-bold text-indigo-600 mb-4">
            Rs {{ number_format($product->price, 2) }}
          </div>

          {{-- Stock & Add to Cart (unchanged) --}}
          <div class="mb-6">
            <!-- Your stock info here -->
          </div>
          <form action="{{ route('cart.index') }}" method="POST" class="mt-6">
            @csrf
            <!-- Add to cart button and quantity input -->
          </form>
        </div>

        {{-- NEW: Submit Your Review --}}
        @auth
        <div class="mt-10 bg-white p-6 rounded-lg shadow">
          <h2 class="text-xl font-semibold mb-2">Leave a Review</h2>
          <div id="star-widget" class="flex space-x-1 mb-3" data-rating="0">
            @for($i=1; $i<=5; $i++)
              <button type="button" data-value="{{ $i }}" class="star h-6 w-6 text-gray-300 hover:text-yellow-400 focus:outline-none">
                <svg viewBox="0 0 20 20" class="fill-current"><use href="#icon-star-full"/></svg>
              </button>
            @endfor
          </div>
          <textarea id="review-comment" rows="3" placeholder="Your comments..." class="w-full border-gray-300 rounded p-2"></textarea>
          <button id="submit-review" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Submit Review
          </button>
        </div>
        @endauth

        {{-- NEW: Existing Reviews --}}
        <div class="mt-10">
          <h2 class="text-2xl font-semibold mb-4">Customer Reviews</h2>
          @forelse($product->reviews as $review)
            <div class="border-b border-gray-200 py-4">
              <div class="flex items-center mb-1">
                <span class="font-medium">{{ $review->user_name ?? 'Anonymous' }}</span>
                <span class="ml-4 text-yellow-400">
                  @for($i=0; $i < $review->rating; $i++)
                    <svg class="inline-block h-4 w-4 fill-current"><use href="#icon-star-full"/></svg>
                  @endfor
                </span>
              </div>
              <p class="text-gray-700 whitespace-pre-line">{{ $review->comment }}</p>
            </div>
          @empty
            <p class="text-gray-500">No reviews yet. Be the first to review!</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  {{-- SVG icons (unchanged) --}}
  <svg style="display: none;">
    <symbol id="icon-star-full" viewBox="0 0 20 20">
      <path d="M10 15l-5.878 3.09L5.64 11.545 1 7.455l6.061-.545L10 2l2.939 4.91 6.061.545-4.64 4.09 1.518 6.545z" />
    </symbol>
    <symbol id="icon-star-half" viewBox="0 0 20 20">
      <path d="M10 15l-5.878 3.09L5.64 11.545 1 7.455l6.061-.545L10 2z" />
    </symbol>
    <symbol id="icon-star-empty" viewBox="0 0 20 20">
      <path d="M10 15l-5.878 3.09L5.64 11.545 1 7.455l6.061-.545L10 2l2.939 4.91 6.061.545-4.64 4.09 1.518 6.545z" fill="none" stroke="currentColor" stroke-width="1.5"/>
    </symbol>
  </svg>

  {{-- JS to wire up star clicks & AJAX submission --}}
 @auth
<script>
  document.getElementById("submit-review").addEventListener("click", function () {
    const productId = "{{ $product->id }}";  // Use your product ID
    const rating = document.querySelector('#star-widget').getAttribute("data-rating");
    const comment = document.getElementById("review-comment").value;

    fetch("/api/reviews", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
      },
      credentials: "include",
      body: JSON.stringify({
        product_id: productId,
        rating: rating,
        comment: comment
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Review submitted successfully!");
        location.reload(); // or update the DOM dynamically
      } else {
        alert("Failed to submit review: " + (data.message ?? "Unknown error"));
      }
    })
    .catch(error => {
      console.error("Error:", error);
      alert("An error occurred while submitting your review.");
    });
  });

  // Star rating click behavior
  document.querySelectorAll('#star-widget .star').forEach((star, index) => {
    star.addEventListener('click', function () {
      const rating = index + 1;
      document.querySelector('#star-widget').setAttribute("data-rating", rating);
      document.querySelectorAll('#star-widget .star').forEach((s, i) => {
        s.classList.toggle('text-yellow-400', i < rating);
        s.classList.toggle('text-gray-300', i >= rating);
      });
    });
  });
</script>
@endauth
</x-app-layout>
