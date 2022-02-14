<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guards = null)
    {
        logger(json_encode($guards));
        logger(json_encode(Auth::user()));
        logger(json_encode(Auth::check()));
        if (Auth::guard($guards)->check()) {
            logger(json_encode($guards));
            if($guards == 'web'){
                return redirect()->to('dashboard');
            }
            else{
                return redirect()->to('login');
            }
        }

        return $next($request);
    }
}
