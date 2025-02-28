<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            @include('components.input-label', ['for' => 'name', 'slot' => __('Name')])
            @include('components.text-input', [
                'id' => 'name',
                'class' => 'block mt-1 w-full',
                'type' => 'text',
                'name' => 'name',
                'value' => old('name'),
                'required' => true,
                'autofocus' => true,
                'autocomplete' => 'name'
            ])
            @include('components.input-error', ['messages' => $errors->get('name'), 'class' => 'mt-2'])
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            @include('components.input-label', ['for' => 'email', 'slot' => __('Email')])
            @include('components.text-input', [
                'id' => 'email',
                'class' => 'block mt-1 w-full',
                'type' => 'email',
                'name' => 'email',
                'value' => old('email'),
                'required' => true,
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
                'autocomplete' => 'new-password'
            ])
            @include('components.input-error', ['messages' => $errors->get('password'), 'class' => 'mt-2'])
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            @include('components.input-label', ['for' => 'password_confirmation', 'slot' => __('Confirm Password')])
            @include('components.text-input', [
                'id' => 'password_confirmation',
                'class' => 'block mt-1 w-full',
                'type' => 'password',
                'name' => 'password_confirmation',
                'required' => true,
                'autocomplete' => 'new-password'
            ])
            @include('components.input-error', ['messages' => $errors->get('password_confirmation'), 'class' => 'mt-2'])
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            @include('components.primary-button', ['class' => 'ms-4', 'slot' => __('Register')])
        </div>
    </form>
</x-guest-layout>
