<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckTokenValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenDate = DB::select('select * from personal_access_tokens where tokenable_id = ?', [Auth::user()->id]);

        if (isset($tokenDate[0])) {
            $dateCreated = new DateTime($tokenDate[0]->created_at);
            $dateNow = new DateTime();
            $interval = $dateCreated->diff($dateNow);

            if ($interval->h <= 2) {
                return $next($request);
            }
        }

        User::where('cad_email', Auth::user()->cad_email)->update(['cad_token_api' => '']);

        auth()->user()->tokens()->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
