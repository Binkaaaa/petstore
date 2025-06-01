<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles (Tailwind & Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-white text-gray-800">
    {{-- Top Bar: Logo + Auth Links/Profile + Cart --}}
    <div class="flex justify-between items-center p-6 max-w-7xl mx-auto bg-white">
        {{-- Logo --}}
        <div>
            <a href="{{ url('/') }}">
                <img src="{{ asset('uploads/logo.png') }}" alt="Logo" class="h-12 w-auto" />
            </a>
        </div>

        {{-- Right-side nav --}}
        <div class="flex items-center space-x-6">
            @auth
                {{-- Cart icon (always visible) --}}
                @php
                    $cartCount = array_sum(array_column(session('cart', []), 'qty'));
                @endphp
                <a href="{{ route('cart.index') }}" class="relative nav-link mr-4">
                    <img src="{{ asset('uploads/cart.png') }}" alt="Cart" class="h-7 w-7" />
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- Profile dropdown --}}
                <x-dropdown text-align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="{{ Auth::user()->profile_photo_url }}"
                                 alt="{{ Auth::user()->name }}" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2">
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <x-dropdown-link :href="route('profile.show')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @else
                <a href="{{ route('register') }}" class="text-black nav-link">Register</a>
                <a href="{{ route('login') }}" class="text-black nav-link">Login</a>
            @endauth
        </div>
    </div>

    {{-- Main Navigation --}}
    <nav class="bg-black border-t border-b border-black">
        <ul class="max-w-7xl mx-auto flex justify-center space-x-12 py-4 text-lg font-semibold">
            <li><a href="{{ route('dashboard') }}" class="text-white hover:text-orange-600">Home</a></li>
            <li class="relative group">
                <a href="#" class="text-white hover:text-orange-600">Categories</a>
                <ul class="absolute left-0 top-full mt-2 w-48 bg-black shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                    @foreach(['Dog Items','Cat Items','Bird Items','Hamster Items','Rabbit Items'] as $cat)
                        <li>
                            <a href="{{ route('products.byCategory', ['categoryName' => $cat]) }}"
                               class="block px-4 py-2 text-white hover:bg-gray-100 hover:text-black">
                                {{ $cat }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li><a href="#" class="text-white hover:text-orange-600">Contact Us</a></li>
        </ul>
    </nav>

    {{-- Page Content --}}
    <div class="min-h-screen bg-gray-100">
        {{-- Page Heading (if provided) --}}
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts
</body>
</html>
