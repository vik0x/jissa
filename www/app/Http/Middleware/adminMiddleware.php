<?php

namespace App\Http\Middleware;

use Closure;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(\Auth::check()){
            if(\Auth::user()->tipo == 1){
                 return $next($request);
            }
            return redirect('/acceder');
        }
        return redirect('/acceder');
    }
}
