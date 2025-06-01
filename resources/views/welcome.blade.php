<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PetPaw - Your Pet’s Favorite Store</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


  <style>
    /* Custom hover for login/register links */
    .nav-link {
      color: black;
      transition: color 0.3s ease;
      position: relative;
      text-decoration: none;
    }
    .nav-link:hover {
      color: #FF5722; /* orangish-red */
      text-decoration: underline;
    }
    /* Dropdown submenu styles */
    .dropdown:hover > .dropdown-menu {
      display: block;
    }
  </style>
</head>
<body class="bg-white text-gray-800">

  <!-- Top bar with logo left and login/register/cart right -->
  <div class="flex justify-between items-center p-6 max-w-7xl mx-auto bg-white">
    <div>
      <!-- Replaced logo with your previous one -->
      <img src="{{ asset('uploads/logo.png') }}" alt="PetPaw Logo" class="h-12 w-auto" />
    </div>
    <div class="flex items-center space-x-6 ">
      <a href="{{ route('register') }}" class="nav-link" >Register</a>
      <a href="{{ route('login') }}" class="nav-link">Login</a>
    </div>
  </div>

<!-- Navigation Bar styled like the image but keeping your black theme -->
<nav class="bg-black border-t border-b border-black">
  <ul class="max-w-7xl mx-auto flex justify-center space-x-12 py-4 text-lg font-semibold">
    <!-- Home -->
    <li>
      <a href="{{ route('dashboard') }}"
         class="text-white hover:text-orange-600">
        Home
      </a>
    </li>

    <!-- Categories dropdown -->
    <li class="relative group">
      <a href="#"
         class="text-white hover:text-orange-600">
        Categories
      </a>
      <ul class="absolute left-0 top-full mt-2 w-48 bg-black shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
        @php
          $cats = ['Dog Items','Cat Items','Bird Items','Hamster Items','Rabbit Items'];
        @endphp

        @foreach($cats as $cat)
          <li>
            <a href="{{ route('products.byCategory', ['categoryName' => $cat]) }}"
               class="block px-4 py-2 text-white hover:bg-gray-100 hover:text-black">
              {{ $cat }}
            </a>
          </li>
        @endforeach
      </ul>
    </li>

    <!-- Contact Us -->
    <li>
      <a href="#"
         class="text-white hover:text-orange-600">
        Contact Us
      </a>
    </li>
  </ul>
</nav>

  <!-- Hero Section Carousel -->
  <div x-data="{
          images: [
            '{{ asset('uploads/homebirdsswipe.jpg') }}',
            '{{ asset('uploads/homecatswipe.jpg') }}',
            '{{ asset('uploads/homecowsswipe.jpg') }}',
            '{{ asset('uploads/homedogsswipe.jpg') }}',
            '{{ asset('uploads/homeducksswipe.jpg') }}',
          ],
          currentIndex: 0,
          next() { this.currentIndex = (this.currentIndex + 1) % this.images.length },
          prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length },
          init() {
            setInterval(() => this.next(), 5000);
          }
        }"
      x-init="init()"
      class="relative w-full h-[500px] overflow-hidden">

    <!-- Slide background -->
    <div class="absolute inset-0 bg-cover bg-center transition-all duration-700"
        :style="`background-image: url(${images[currentIndex]})`">
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 text-white text-center max-w-3xl mx-auto py-32 px-4">
      <h1 class="text-5xl font-extrabold mb-6">Give Your Pet the Love They Deserve</h1>
      <p class="text-xl mb-8">Shop the best quality food, toys, and accessories for your furry friends!</p>
      <a
        href="#"
        class="inline-block bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg font-semibold transition"
      >
        Shop Now
      </a>
    </div>

    <!-- Arrows -->
    <button @click="prev"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white rounded-full p-3 z-20">
        &#10094;  
    </button>
    <button @click="next"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white rounded-full p-3 z-20">
        &#10095;
    </button>
  </div>


  <!-- Categories section -->
  <section class="py-10">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Browse by Category</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6 justify-center">

        @php
          $categories = [
            ['name' => 'Bird', 'image' => 'bird.jpg'],
            ['name' => 'Cat', 'image' => 'cat.webp'],
            ['name' => 'Dog', 'image' => 'dog.avif'],
            ['name' => 'Hamster', 'image' => 'hamser.jpg'],
            ['name' => 'Rabbit', 'image' => 'rabbit.jpg'],
          ];
        @endphp

        @foreach ($categories as $category)
          <div x-data="{ animate: false }" @click="animate = true; setTimeout(() => animate = false, 400)"
              class="flex flex-col items-center space-y-2 transition-transform duration-500 ease-in-out cursor-pointer">

            <img src="{{ asset('uploads/' . $category['image']) }}" alt="{{ $category['name'] }}"
                :class="animate ? 'animate-bounce' : ''"
                class="w-32 h-32 object-cover rounded-full border-4 border-gray-300 hover:border-orange-500 transition duration-300 shadow-lg">
            
            <span class="text-gray-700 font-medium hover:text-orange-600">{{ $category['name'] }}</span>
          </div>
        @endforeach

      </div>
    </div>
  </section>
<BR>
  <HR>
  <br>

<!-- latest toys -->
  <section class="max-w-7xl mx-auto mt-16 px-6">
    <h2 class="text-3xl font-bold mb-6">Latest Toys</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

        <!-- Product Block -->
      <div class="group text-center relative bg-white p-4">
        <img src="/uploads/toys/RingToyFordogs.avif" alt="Ring Toy for Dogs"
          class="w-full h-48 object-contain mx-auto mb-3 transition group-hover:scale-105" />
        <h3 class="font-semibold text-lg">Ring Toy for Dogs</h3>
        <p class="text-gray-500 text-sm">Durable chew and fetch toy.</p>
        <p class="text-pink-600 font-bold mt-1">Rs. 1,200.00</p>

      <!-- Button Container -->
      <div class="opacity-0 group-hover:opacity-100 transition duration-300 mt-4">
        <a href="/products/dogs"
          class="inline-block bg-black text-white text-sm font-semibold py-2 px-4 rounded hover:bg-orange-500 transition">
          Explore More
        </a>
      </div>
    </div>

    <div class="group text-center relative">
      <img src="/uploads/toys/RustlingBoneDogToy.avif" alt="Rustling Bone Dog Toy" class="w-full h-48 object-contain mx-auto mb-3 transition group-hover:scale-105" />
      <h3 class="font-semibold text-lg">Rustling Bone Dog Toy</h3>
      <p class="text-gray-500 text-sm">Fun squeaky bone for active pups.</p>
      <p class="text-pink-600 font-bold mt-1">Rs. 950.00</p>
      <div class="absolute inset-0 flex items-end justify-center opacity-0 group-hover:opacity-100 transition mt-6">
        <a href="/products/dogs" class="bg-black text-white text-sm font-semibold py-2 px-4 rounded shadow hover:bg-orange-500 transition">Explore More</a>
      </div>
    </div>

    <div class="group text-center relative">
      <img src="/uploads/toys/TrixiePlayingRodWithMouse.avif" alt="Trixie Playing Rod" class="w-full h-48 object-contain mx-auto mb-3 transition group-hover:scale-105" />
      <h3 class="font-semibold text-lg">Trixie Playing Rod</h3>
      <p class="text-gray-500 text-sm">Interactive wand toy for cats.</p>
      <p class="text-pink-600 font-bold mt-1">Rs. 850.00</p>
      <div class="absolute inset-0 flex items-end justify-center opacity-0 group-hover:opacity-100 transition mt-6">
        <a href="/products/cats" class="bg-black text-white text-sm font-semibold py-2 px-4 rounded shadow hover:bg-orange-500 transition">Explore More</a>
      </div>
    </div>

    <div class="group text-center relative">
      <img src="/uploads/toys/WildCatscratchingCartboard.avif" alt="Wild Cat Scratching Board" class="w-full h-48 object-contain mx-auto mb-3 transition group-hover:scale-105" />
      <h3 class="font-semibold text-lg">Wild Cat Scratching Board</h3>
      <p class="text-gray-500 text-sm">Satisfies scratching urges naturally.</p>
      <p class="text-pink-600 font-bold mt-1">Rs. 1,100.00</p>
      <div class="absolute inset-0 flex items-end justify-center opacity-0 group-hover:opacity-100 transition mt-6">
        <a href="/products/cats" class="bg-black text-white text-sm font-semibold py-2 px-4 rounded shadow hover:bg-orange-500 transition">Explore More</a>
      </div>
    </div>

  </div>
</section>

<br>
<br>
<br>
<hr>

<!-- Best Selling Products Section -->
<section class="max-w-7xl mx-auto mt-20 px-6">
  <h2 class="text-3xl font-bold mb-6">Best Selling Products</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

    <!-- Bird Food -->
    <div class="group text-center relative bg-white p-4">
      <img src="/uploads/food/birdfood.avif" alt="Bird Food" class="w-full h-48 object-contain mx-auto mb-3 transition group-hover:scale-105" />
      <h3 class="font-semibold text-lg">Bugie Special Mix</h3>
      <p class="text-gray-500 text-sm">Nutritious seeds and grains for your birds.</p>
      <p class="text-pink-600 font-bold mt-1">Rs. 850.00</p>
      <!-- Button Container -->
      <div class="opacity-0 group-hover:opacity-100 transition duration-300 mt-4">
        <a href="/products/birds"
          class="inline-block bg-black text-white text-sm font-semibold py-2 px-4 rounded hover:bg-orange-500 transition">
          Explore More
        </a>
      </div>
    </div>

    <!-- Cat Food -->
    <div class="group text-center relative">
      <img src="/uploads/food/catfood.avif" alt="Cat Food" class="w-full h-48 object-contain mx-auto mb-3 transition group-hover:scale-105" />
      <h3 class="font-semibold text-lg">Meow Mix Original Choice</h3>
      <p class="text-gray-500 text-sm">Healthy meals for your furry friend.</p>
      <p class="text-pink-600 font-bold mt-1">Rs. 1,200.00</p>
      <div class="absolute inset-0 flex items-end justify-center opacity-0 group-hover:opacity-100 transition mt-6">
        <a href="/products/cats" class="bg-black text-white text-sm font-semibold py-2 px-4 rounded shadow hover:bg-orange-500 transition">Explore More</a>
      </div>
    </div>

    <!-- Dog Food -->
    <div class="group text-center relative">
      <img src="/uploads/food/dogfood.avif" alt="Dog Food" class="w-full h-48 object-contain mx-auto mb-3 transition group-hover:scale-105" />
      <h3 class="font-semibold text-lg">Feed Me!</h3>
      <p class="text-gray-500 text-sm">Wholesome nutrition for dogs of all sizes.</p>
      <p class="text-pink-600 font-bold mt-1">Rs. 1,500.00</p>
      <div class="absolute inset-0 flex items-end justify-center opacity-0 group-hover:opacity-100 transition mt-6">
        <a href="/products/dogs" class="bg-black text-white text-sm font-semibold py-2 px-4 rounded shadow hover:bg-orange-500 transition">Explore More</a>
      </div>
    </div>

    <!-- Hamster Food -->
    <div class="group text-center relative">
      <img src="/uploads/food/hamsterfood.webp" alt="Hamster Food" class="w-full h-48 object-contain mx-auto mb-3 transition group-hover:scale-105" />
      <h3 class="font-semibold text-lg">Hamster</h3>
      <p class="text-gray-500 text-sm">Perfect blend of grains and nutrients.</p>
      <p class="text-pink-600 font-bold mt-1">Rs. 600.00</p>
      <div class="absolute inset-0 flex items-end justify-center opacity-0 group-hover:opacity-100 transition mt-6">
        <a href="/products/hamsters" class="bg-black text-white text-sm font-semibold py-2 px-4 rounded shadow hover:bg-orange-500 transition">Explore More</a>
      </div>
    </div>

  </div>
</section>
<br>
<br>
<br>


<!-- Footer Section -->
<footer class="bg-black text-white px-6 py-14">
  <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">

    <!-- About Column -->
    <div>
      <h2 class="text-xl font-extrabold text-white mb-4">PetPaw</h2>
      <p class="text-sm text-gray-300 leading-relaxed">
        Providing premium pet care essentials with love and dedication to keep your furry friends happy and healthy.
      </p>
    </div>

    <!-- Shop Column -->
    <div>
      <h3 class="text-lg font-semibold text-white mb-3">Shop</h3>
      <ul class="space-y-2 text-sm text-gray-300">
        <li><a href="#" class="hover:text-white">Home</a></li>
        <li><a href="#" class="hover:text-white">Category</a></li>
        <li><a href="#" class="hover:text-white">Contact Us</a></li>
      </ul>
    </div>

    <!-- Account Column -->
    <div>
      <h3 class="text-lg font-semibold text-white mb-3">My Account</h3>
      <ul class="space-y-2 text-sm text-gray-300">
        <li><a href="#" class="hover:text-white">Login</a></li>
        <li><a href="#" class="hover:text-white">Logout</a></li>
        <li><a href="#" class="hover:text-white">Cart</a></li>
      </ul>
    </div>

    <!-- Subscribe Column -->
    <div>
      <h3 class="text-lg font-semibold text-white mb-3">Sign Up for Updates</h3>
      <p class="text-sm text-gray-300 mb-4">Get the latest news about our products and promotions.</p>
      <form class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3">
        <input type="email" placeholder="Your email address"
          class="w-full sm:w-auto px-4 py-2 rounded-md bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white" />
        <button type="submit"
          class="px-4 py-2 rounded-md bg-white text-black font-semibold hover:bg-gray-200 transition">
          Subscribe
        </button>
      </form>
    </div>

  </div>

  <!-- Divider -->
  <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-400">
    © 2025 PetPaw. All Rights Reserved.
  </div>
</footer>



</body>
</html>
