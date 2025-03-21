<x-guest-layout>
    <!-- Session Status -->
    @include('components.auth-session-status')

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            @include('components.input-label', ['for' => 'email', 'slot' => __('Email')])
            @include('components.text-input', [
                'id' => 'email',
                'class' => 'block mt-1 w-full',
                'type' => 'email',
                'name' => 'email',
                'value' => old('email'),
                'required' => true,
                'autofocus' => true,
                'autocomplete' => 'username'
            ])
            @include('components.input-error', ['messages' => $errors->get('email'), 'class' => 'mt-2'])
        </div>

        <!-- Password -->
        <div class="mt-4">
            @include('components.input-label', ['for' => 'password', 'slot' => __('Password')])

            @include('components.text-input', [
                'id' => 'password',
                'class' => 'block mt-1 w-full',
                'type' => 'password',
                'name' => 'password',
                'required' => true,
                'autocomplete' => 'current-password'
            ])

            @include('components.input-error', ['messages' => $errors->get('password'), 'class' => 'mt-2'])
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            @include('components.primary-button', ['class' => 'ms-3', 'slot' => __('Log in')])
        </div>
    </form>
</x-guest-layout>
