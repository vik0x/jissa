<?php

namespace App\Http\Middleware;

use Closure;

class logMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        // print_r(get_class_methods($request));
        // echo $request->url();
        // exit;
        return $next($request);
    }
}
