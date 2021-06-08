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
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guard = null;


        if ($request->is('admin/*')) {
            if(Auth::guard('admin')->check()){
                return redirect()->route('admin.dashbord');
            }
        }elseif (Auth::guard('web')->check()){
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
