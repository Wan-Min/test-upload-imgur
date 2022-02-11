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
    // public function handle(Request $request, Closure $next, ...$guards)
    // {
    //     $guards = empty($guards) ? [null] : $guards;

    //     foreach ($guards as $guard) {
    //         if (Auth::guard($guard)->check()) {
    //             // return redirect(RouteServiceProvider::HOME);
    //             return redirect()->route('dashboard');
    //         }
    //     }

    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next, $guards = null)
    {
        logger(json_encode(auth()->user()));
        logger(json_encode(Auth::user()));
        logger(json_encode(Auth::check()));
        if (Auth::guard($guards)->check()) {
            // if (Auth::guard($guards)->check()) {
            logger(json_encode($guards));
            if($guards == 'web'){
                return redirect()->to('dashboard');
            }
            else{
                return redirect()->to('loginPage');
            }
        }

        return $next($request);
    }
}
