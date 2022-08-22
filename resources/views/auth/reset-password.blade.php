<head>
    <title>Esqueceu Sua Senha?</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/appLogin.css') }}">
</head>
<body>
    <x-guest-layout>
        <x-auth-card>
            <x-slot name="logo">
                <img src="{{ asset('/images/logo.png') }}" alt="logo" class="text-gray-500 img-fluid" style="height: 25vh; width: 15vw">
            </x-slot>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-label for="cad_email" :value="__('Email')" />

                    <x-input id="cad_email" class="block mt-1 w-full" type="email" name="cad_email" :value="old('email', $request->email)" required autofocus />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="cad_senha" :value="__('Senha')" />

                    <x-input id="cad_senha" class="block mt-1 w-full" type="password" name="cad_senha" required />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-label for="cad_senha_confirmation" :value="__('Confirmar Senha')" />

                    <x-input id="cad_senha_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="cad_senha_confirmation" required />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        {{ __('Alterar Senha') }}
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
