<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create($token, Request $request)
    {
        $token = DB::table('password_resets')->where('token', $token)->first();
        
        if (!$token) {
            return redirect()->route('login')->with('status', __('Token Inválido! Tente Enviar o Email Novamente'));
        }

        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'cad_email' => ['required', 'email'],
            'cad_senha' => ['required', 'confirmed', 'min:8'],
        ],
        [
            'token.required' => 'Token Inválido! Tente Enviar o Email Novamente',
            'cad_email.required' => 'O campo E-mail é obrigatório!',
            'cad_senha.required' => 'O campo Senha é obrigatório!',
            'cad_senha.confirmed' => 'As Senhas não conferem!',
            'cad_senha.min' => 'Sua nova senha deve ter no mínino 8 caracteres!'
        ]);

        $token = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$token) {
            back()->with('status', __('Token Inválido! Tente Enviar o Email Novamente'));
        }

        User::where('cad_email', $request->cad_email)->update([
            'cad_senha' => Hash::make($request->cad_senha),
            'remember_token' => Str::random(60),
        ]);

        DB::table('password_resets')->where('email', $request->cad_email)->delete();

        return redirect()->route('login')->with('status', __('Senha alterada com Sucesso'));
    }
}
