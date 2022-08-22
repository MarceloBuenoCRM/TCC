<head>
    <title>Esqueceu Sua Senha?</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/appLogin.css') }}">
</head>
<body>
    <x-guest-layout>
        <x-auth-card>
            <x-slot name="logo">
                <img src="{{ asset('/images/logo.png') }}" alt="logoTheWall" class="text-gray-500 img-fluid" style="height: 25vh; width: 15vw">
            </x-slot>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Insira o seu E-mail de cadastro para enviarmos um link de redefinição de senha.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

            @error('msg')
                <div class="font-medium text-red-600">
                    Ops! Algo está errado.
                </div>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        <li>{{$message}}</li>
                </ul>
            @enderror

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-label for="cad_email" :value="__('Email')" />

                    <x-input id="cad_email" class="block mt-1 w-full" type="email" name="cad_email" :value="old('cad_email')" required autofocus />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="btn btn-light btn-sm" href="/" style="margin-left: 10px">Cancelar</a>
                    <x-button>
                        {{ __('Enviar') }}
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
