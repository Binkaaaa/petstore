<x-app-layout>
    <br>

    <div class="max-w-md mx-auto mt-12 p-8 bg-white rounded-lg shadow-md">
        <div class="mb-8 text-center">
            <img src="{{ asset('uploads/logo.png') }}" alt="PetPaw Logo" class="mx-auto w-28 h-auto" />
            <h1 class="mt-4 text-3xl font-extrabold text-gray-900">Create an Account</h1>
            <p class="mt-2 text-sm text-gray-600">Join PetPaw and get started today!</p>
        </div>

        <x-validation-errors class="mb-6" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mb-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mb-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mb-6">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mb-6">
                    <label for="terms" class="flex items-center space-x-2 text-sm text-gray-700">
                        <x-checkbox name="terms" id="terms" required />
                        <span>
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-orange-600 hover:text-orange-800">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-orange-600 hover:text-orange-800">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </span>
                    </label>
                </div>
            @endif

            <div class="flex items-center justify-between">
                <a class="text-sm text-gray-600 hover:text-orange-600 underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="bg-orange-500 hover:bg-orange-600 focus:ring-orange-500">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
