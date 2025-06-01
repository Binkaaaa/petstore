<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg border border-gray-200">
            <div class="mb-8 text-center">
                <img src="{{ asset('uploads/logo.png') }}" alt="PetPaw Admin Logo" class="mx-auto w-28 h-auto" />
                <h1 class="mt-4 text-3xl font-extrabold text-gray-900">Admin Portal</h1>
                <p class="mt-2 text-sm text-gray-600">Secure login for administrators only</p>
            </div>

            <x-validation-errors class="mb-6 text-red-600" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ isset($guard) ? url($guard . '/login') : route('login') }}">
                @csrf

                <div class="mb-5">
                    <x-label for="email" value="{{ __('Email') }}" class="text-gray-700" />
                    <x-input id="email" class="block mt-1 w-full rounded-md border border-gray-300 focus:border-orange-500 focus:ring-orange-500" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@example.com" />
                </div>

                <div class="mb-6">
                    <x-label for="password" value="{{ __('Password') }}" class="text-gray-700" />
                    <x-input id="password" class="block mt-1 w-full rounded-md border border-gray-300 focus:border-orange-500 focus:ring-orange-500" 
                        type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>

                <div class="flex items-center mb-6">
                    <label for="remember_me" class="flex items-center space-x-2 text-sm text-gray-600 cursor-pointer select-none">
                        <x-checkbox id="remember_me" name="remember" class="text-orange-500 focus:ring-orange-500" />
                        <span>Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-orange-600 hover:text-orange-700 underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                           Forgot your password?
                        </a>
                    @endif

                    <x-button class="bg-orange-600 hover:bg-orange-700 focus:ring-orange-600">
                        Log In
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
