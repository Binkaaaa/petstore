<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @vite(['resources/css/app.css'])
  <title>Admin Dashboard</title>
</head>
<body class="flex h-screen font-sans bg-white text-gray-900">

  {{-- Sidebar --}}
  <aside class="flex-shrink-0 w-20 bg-white border-r border-gray-300 flex flex-col items-center py-6 space-y-8">
    {{-- Logo --}}
    <a href="#" class="block w-12 h-12 rounded-full overflow-hidden border border-gray-800 hover:border-black transition">
      <img src="{{ asset('uploads/logo.png') }}" alt="PetPaw Logo" class="w-full h-full object-cover" />
    </a>

    {{-- Nav Icons --}}
    <nav class="flex-1 flex flex-col items-center space-y-10">
      <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-black transition" title="Dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75l9-7.5 9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V9.75z" />
        </svg>
      </a>
      <a href="{{ route('admin.products') }}" class="text-gray-700 hover:text-black transition" title="Products">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4v10l-9 4-9-4V7z" />
        </svg>
      </a>
      <a href="{{ route('admin.users') }}" class="text-gray-700 hover:text-black transition" title="Users">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 11a4 4 0 1 0-8 0 4 4 0 0 0 8 0zm2.5 1a6.5 6.5 0 0 1 6.5 6.5v1h-19v-1A6.5 6.5 0 0 1 5.5 12H18.5z" />
        </svg>
      </a>
      <a href="{{ route('admin.orders.index') }}" class="text-gray-700 hover:text-black transition" title="Orders">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 2h6v2h5v18H4V4h5V2zM6 6v14h12V6H6zm2 3h8v2H8V9zm0 4h8v2H8v-2z" />
        </svg>
      </a>
      <a href="{{ route('admin.reviews.index') }}" class="text-gray-700 hover:text-black transition" title="Reviews">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
        </svg>
      </a>
    </nav>

    {{-- Logout --}}
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit" class="text-gray-700 hover:text-red-600 transition" title="Logout">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 17l5-5-5-5v3H9v4h7v3zM4 4h6v2H6v12h4v2H4V4z" />
        </svg>
      </button>
    </form>
  </aside>

  {{-- Main Content --}}
  <div class="flex-1 flex flex-col overflow-hidden">
    {{-- Top Navbar --}}
    <header class="flex items-center justify-between bg-white border-b border-gray-300 px-8 py-4 shadow-sm">
      <h2 class="text-2xl font-semibold text-black tracking-wide">Dashboard</h2>
      <div class="flex items-center space-x-6">
        <span class="text-gray-900 font-medium">Hello, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
        <img src="{{ asset('uploads/adminpfp.png') }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border-2 border-black" />
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="px-4 py-2 bg-black rounded text-white font-semibold hover:bg-white hover:text-black border border-black transition">
            Logout
          </button>
        </form>
      </div>
    </header>

    {{-- Content --}}
    <main class="flex-1 overflow-auto p-8 bg-white">
      <div class="mb-10">
        <h1 class="text-4xl font-bold text-black tracking-tight">Welcome, Admin</h1>
        <p class="mt-2 text-gray-700 max-w-lg">Use the sidebar to navigate through the management sections quickly and efficiently.</p>
      </div>

      {{-- Cards Grid --}}
      <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        {{-- Products Card --}}
        <div class="bg-white border border-gray-300 rounded-lg shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-semibold text-black">Products</h3>
          </div>
          <div class="space-y-3">
            <a href="{{ route('admin.products') }}" class="block py-2 text-center bg-black text-white rounded border border-black hover:bg-white hover:text-black transition font-semibold">
              Add Product
            </a>
            <a href="{{ route('admin.products') }}" class="block py-2 text-center bg-black text-white rounded border border-black hover:bg-white hover:text-black transition font-semibold">
              Edit/Delete
            </a>
          </div>
        </div>

        {{-- Users Card --}}
        <div class="bg-white border border-gray-300 rounded-lg shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-semibold text-black">Users</h3>
          </div>
          <a href="{{ route('admin.users') }}" class="block py-2 text-center bg-black text-white rounded border border-black hover:bg-white hover:text-black transition font-semibold">
            View/Delete Users
          </a>
        </div>

        {{-- Orders Card --}}
        <div class="bg-white border border-gray-300 rounded-lg shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-semibold text-black">Orders</h3>
          </div>
          <a href="{{ route('admin.orders.index') }}" class="block py-2 text-center bg-black text-white rounded border border-black hover:bg-white hover:text-black transition font-semibold">
            View Orders
          </a>
        </div>

        {{-- Reviews Card --}}
        <div class="bg-white border border-gray-300 rounded-lg shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-semibold text-black">Reviews</h3>
          </div>
          <a href="{{ route('admin.reviews.index') }}" class="block py-2 text-center bg-black text-white rounded border border-black hover:bg-white hover:text-black transition font-semibold">
            View Reviews
          </a>
        </div>
      </div>
    </main>
  </div>

</body>
</html>
