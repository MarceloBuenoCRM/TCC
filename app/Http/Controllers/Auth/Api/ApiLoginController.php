<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'cad_email' => 'required',
            'cad_senha' => 'required',
        ],
        [
            'cad_email.required' => 'Email é um parâmetro necessário!',
            'cad_senha.required' => 'Senha é um parâmetro necessário!'
        ]);

        $credentials = $request->only('cad_email', 'cad_senha');

        $user = User::where('cad_email', $credentials['cad_email']);
      
        if(!$user->first() || !Hash::check($credentials['cad_senha'], $user->first()->cad_senha)) {
            abort(401, 'Credenciais Inválidas');
        }

        Auth::login($user->first());
        
        $token = Auth::user()->createToken(Auth::user()->cad_email);
       
        return response()->json([
            'data' => [
                'token' => substr($token->plainTextToken, strpos($token->plainTextToken, "|") + 1),
                'user' => Auth::user()->cad_nome,
                'cad_modo_escuro' => Auth::user()->cad_modo_escuro,
            ]
        ]);
    }

    public function returnToken()
    {
        return response()->json([
            'data' => [
                'token' => substr(Auth::user()->cad_token_api, strpos(Auth::user()->cad_token_api, "|") + 1),
                'user' => Auth::user()->cad_nome,
                'cad_modo_escuro' => Auth::user()->cad_modo_escuro,
            ]
        ]); 
    }

    public function logout(Request $request)
    {
        $request->validate([
            'cad_email' => 'required'
        ],
        [
            'cad_email.required' => 'Email é um parâmetro necessário!'
        ]);

        DB::table('personal_access_tokens')->where('name', $request->get('cad_email'))->delete();

        return response()
                ->json([], 204);
    }
}
