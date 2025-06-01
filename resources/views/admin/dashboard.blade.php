<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  @vite(['resources/css/app.css'])

  <title>Admin Dashboard</title>
</head>
<body class="flex h-screen font-sans bg-white text-black">

  {{-- Sidebar --}}
  <aside class="flex-shrink-0 w-20 bg-black flex flex-col items-center py-6 space-y-6">
    {{-- Logo --}}
    <a href="#" class="block w-10 h-10 bg-white rounded-full overflow-hidden">
      <img src="{{ asset('uploads/logo.png') }}" alt="PetPaw Logo" class="w-full h-full object-cover" />
    </a>

    {{-- Nav Icons --}}
    <nav class="flex-1 flex flex-col items-center space-y-8">
      <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-400" title="Dashboard">
        <!-- Home Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
          <path d="M3 9.75l9-7.5 9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V9.75z"/>
        </svg>
      </a>
      <a href="{{ route('admin.products') }}" class="text-white hover:text-gray-400" title="Products">
        <!-- Products Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
          <path d="M3 7l9-4 9 4v10l-9 4-9-4V7z"/>
        </svg>
      </a>
      <a href="{{ route('admin.users') }}" class="text-white hover:text-gray-400" title="Users">
        <!-- Users Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
          <path d="M16 11a4 4 0 1 0-8 0 4 4 0 0 0 8 0zm2.5 1a6.5 6.5 0 0 1 6.5 6.5v1h-19v-1A6.5 6.5 0 0 1 5.5 12H18.5z"/>
        </svg>
      </a>
      <a href="{{ route('admin.orders.index') }}" class="text-white hover:text-gray-400" title="Orders">
        <!-- Orders Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
          <path d="M9 2h6v2h5v18H4V4h5V2zM6 6v14h12V6H6zm2 3h8v2H8V9zm0 4h8v2H8v-2z"/>
        </svg>
      </a>
      <a href="{{ route('admin.reviews.index') }}" class="text-white hover:text-gray-400" title="Reviews">
        <!-- Reviews Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
          <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
        </svg>
      </a>
    </nav>

    {{-- Logout --}}
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit" class="hover:text-gray-400" title="Logout">
        <!-- Logout Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
          <path d="M16 17l5-5-5-5v3H9v4h7v3zM4 4h6v2H6v12h4v2H4V4z"/>
        </svg>
      </button>
    </form>
  </aside>

  {{-- Main Content --}}
  <div class="flex-1 flex flex-col overflow-hidden">
    {{-- Top Navbar --}}
    <header class="flex items-center justify-between bg-white shadow px-6 py-4">
      <h2 class="text-xl font-semibold">Dashboard</h2>
      <div class="flex items-center space-x-4">
        <span class="text-gray-700">Hello, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
        <img src="{{ asset('uploads/adminpfp.png') }}" alt="Profile" class="w-8 h-8 rounded-full object-cover" />
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="ml-4 px-3 py-1 bg-black text-white rounded hover:bg-gray-800 transition">
            Logout
          </button>
        </form>
      </div>
    </header>

    {{-- Content --}}
    <main class="flex-1 overflow-auto p-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold">Welcome, Admin</h1>
        <p class="mt-1 text-gray-600">Use the sidebar to navigate through management sections.</p>
      </div>

      {{-- Cards Grid --}}
      <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        {{-- Products Card --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold">Products</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
          </div>
          <div class="space-y-2">
            <a href="{{ route('admin.products') }}" class="block text-center py-2 border border-black rounded hover:bg-black hover:text-white transition">Add Product</a>
            <a href="{{ route('admin.products') }}" class="block text-center py-2 border border-black rounded hover:bg-black hover:text-white transition">Edit/Delete</a>
          </div>
        </div>

        {{-- Users Card --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold">Users</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
          </div>
          <a href="{{ route('admin.users') }}" class="block text-center py-2 border border-black rounded hover:bg-black hover:text-white transition">View/Delete Users</a>
        </div>

        {{-- Orders Card --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold">Orders</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
          </div>
          <a href="{{ route('admin.orders.index') }}" class="block text-center py-2 border border-black rounded hover:bg-black hover:text-white transition">View Orders</a>
        </div>

        {{-- Reviews Card --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold">Reviews</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
          </div>
          <a href="{{ route('admin.reviews.index') }}" class="block text-center py-2 border border-black rounded hover:bg-black hover:text-white transition">View Reviews</a>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
