<head>
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/appLogin.css') }}">
</head>
<body style="background-image: url({{asset('images/fundoLogin.jpg')}}) !important">
    <x-guest-layout>
        <x-auth-card>
            <x-slot name="logo">
                <img src="{{ asset('/images/logo.png') }}" alt="logoTheWall" class="text-gray-500 img-fluid" style="height: 15vh; min-width: 8vw">
            </x-slot>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-label for="cad_email" :value="__('Email')" />

                    <x-input id="cad_email" class="block mt-1 w-full" type="email" name="cad_email" :value="old('cad_email')" required autofocus />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" :value="__('Senha')" />

                    <x-input id="cad_senha" class="block mt-1 w-full"
                                    type="password"
                                    name="cad_senha"
                                    required autocomplete="current-password" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Lembre-se de Mim') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Esqueceu sua Senha?') }}
                        </a>
                    @endif

                    <x-button class="ml-3">
                        {{ __('Entrar') }}
                    </x-button>
                </div>
            </form>
        </x-auth-card>
    </x-guest-layout>
</body>

<style>
    .min-h-screen {
        background-image: url({{asset('images/fundoLogin.jpg')}});
    }
    .w-full {
        background-color: rgb(248, 248, 248);
        border: 2px solid rgb(155, 155, 155);
    }
</style>
