<x-app-layout>
  <div class="max-w-5xl mx-auto px-6 py-12 space-y-16 text-gray-800">

    <!-- Title -->
    <div class="text-center">
      <h1 class="text-5xl font-bold text-orange-600 mb-4">Contact Us</h1>
      <p class="text-lg text-gray-600">We're here to help you and your furry friends.</p>
    </div>

    <!-- About Section -->
    <section>
      <h2 class="text-3xl font-semibold mb-4">About PetPaw</h2>
      <p class="text-gray-700 text-lg leading-relaxed">
        At <strong>PetPaw</strong>, we're passionate about pets. Located in the heart of Kandy, Sri Lanka, we provide top-quality food, toys, grooming supplies, and expert care
        guidance for all types of pets. Whether you're a first-time pet owner or a seasoned animal lover, PetPaw is your go-to partner in pet care.
      </p>

      <!-- Image -->
      <div class="mt-6">
        <img src="{{ asset('uploads/about.jpg') }}" alt="About PetPaw" class="w-full rounded-2xl shadow-lg object-cover">
      </div>
    </section>

    <!-- Divider -->
    <hr class="border-t-2 border-orange-300 my-12">

    <!-- Location Section -->
    <section>
      <h2 class="text-3xl font-semibold mb-4">Our Location</h2>
      <p class="text-gray-700 text-lg mb-6">
        Find us at our flagship store and visit our team in person. We’re always excited to meet fellow pet lovers!
      </p>
      <div class="rounded-2xl overflow-hidden shadow-lg">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2481.498758487205!2d-0.15988082337791043!3d51.54075277182095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761ae949eee111%3A0xaf8a693191f06254!2sPrimrose%20Hill%20Pet%20Pavilion!5e0!3m2!1sen!2slk!4v1748783734958!5m2!1sen!2slk"
          width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </section>

    <!-- Divider -->
    <hr class="border-t-2 border-orange-300 my-12">

    <!-- Contact Information -->
    <section>
      <h2 class="text-3xl font-semibold mb-4">Get in Touch</h2>
      <p class="text-gray-700 text-lg mb-6">
        Have a question or need support? Reach out via the contact details below, and our team will assist you promptly.
      </p>

      <div class="grid md:grid-cols-2 gap-6 text-lg">
        <div>
          <p><strong>Email:</strong> <a href="mailto:support@petpaw.lk" class="text-orange-600 hover:underline">support@petpaw.lk</a></p>
          <p><strong>Phone:</strong> <a href="tel:+94111234567" class="text-orange-600 hover:underline">+94 11 123 4567</a></p>
          <p><strong>Address:</strong> Primrose Street, Kandy, Sri Lanka</p>
        </div>

        <div>
          <p><strong>Business Hours:</strong></p>
          <ul class="text-gray-700">
            <li>Mon – Fri: 9:00 AM – 6:00 PM</li>
            <li>Saturday: 9:00 AM – 1:00 PM</li>
            <li>Sunday: Closed</li>
          </ul>
        </div>
      </div>
    </section>

  </div>
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
</x-app-layout>
