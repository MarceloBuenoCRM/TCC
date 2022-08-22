<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'cad_email' => ['required', 'email'],
        ]);

        $user = User::where('cad_email', $request->cad_email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['msg' => 'Não conseguimos encontrar um usuário com este e-mail cadastrado no sistema.'])->withInput();
        }

        $token = DB::table('password_resets')->where('email', $request->cad_email);

        if($token->first()) {
            $token->delete();
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->cad_email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('mail.layout', ['token' => $token, 'cad_email' => $request->cad_email], function($message) use($request){

            $message->to($request->cad_email);

            $message->subject('Notificação de Redefinição de Senha');

        });

        return back()->with('status', __('Enviamos o link no seu e-mail para redefinir sua senha!'));
    }
}
