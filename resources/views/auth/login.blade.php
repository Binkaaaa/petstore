<x-app-layout>
    <br>
    
    <div class="max-w-md mx-auto mt-12 p-8 bg-white rounded-lg shadow-md">
        <div class="mb-8 text-center">
            <img src="{{ asset('uploads/logo.png') }}" alt="PetPaw Logo" class="mx-auto w-28 h-auto" />
            <h1 class="mt-4 text-3xl font-extrabold text-gray-900">Welcome Back</h1>
            <p class="mt-2 text-sm text-gray-600">Log in to your PetPaw account</p>
        </div>

        <x-validation-errors class="mb-6" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ isset($guard) ? url($guard . '/login') : route('login') }}">
            @csrf

            <div class="mb-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mb-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mb-6">
                <label for="remember_me" class="flex items-center space-x-2 text-sm text-gray-600">
                    <x-checkbox id="remember_me" name="remember" />
                    <span>{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 hover:text-orange-600 underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="bg-orange-500 hover:bg-orange-600 focus:ring-orange-500">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
