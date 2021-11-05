<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;

class TwoFactorAuth
{
   
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user_2fa')) {
            return redirect()->route('2fa.index');
        }
        return $next($request);
    }
}
