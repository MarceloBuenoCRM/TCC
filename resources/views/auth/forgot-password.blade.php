<head>
    <title>Name - Esqueceu Sua Senha?</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/appLogin.css') }}">
</head>
<body style="background-image: url({{asset('images/fundoLogin.jpg')}}) !important">
    <x-guest-layout>
        <x-auth-card>
            <x-slot name="logo"> 
                <img src="{{ asset('/images/logo.png') }}" alt="logoTheWall" class="text-gray-500 img-fluid" style="height: 25vh; width: 15vw">
            </x-slot>
    
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Insira o seu Email de cadastro para enviarmos um Link para trocar sua senha por uma nova.') }}
            </div>
    
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
    
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
    
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
    
                <!-- Email Address -->
                <div>
                    <x-label for="cad_email" :value="__('Email')" />
    
                    <x-input id="cad_email" class="block mt-1 w-full" type="email" name="cad_email" :value="old('cad_email')" required autofocus />
                </div>
    
                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        {{ __('Enviar') }}
                    </x-button>
                    <a class="btn btn-primary" href="/" style="margin-left: 10px">Voltar</a>
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