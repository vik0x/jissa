<?php

namespace App\Http\Middleware;

use Closure;

class privilegioMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return $next($request);
        $privilegios = \DB::table('sys_privilegios as pr')
            ->select('p.accion','m.slug')
            ->join('sys_modulo as m','m.id_modulo','=','pr.id_modulo')
            ->join('sys_permiso as p','p.id_permiso','=','pr.id_permiso')
            ->where('pr.id_rol',session('rol'))
            ->get();
        foreach($privilegios as $key => $priv){
            $privilegios[$key] = trim($priv->accion) == "" ? '/administrador/' . $priv->slug : '/administrador/' . $priv->accion . '/' . $priv->slug;
        }

        $url = $request->getRequestUri();
        // $url = explode("/administrador", $url);
        // $url = end($url);
        $url = substr($url, 0,-5);

        if(in_array($url, $privilegios))
            return $next($request);
        else{
            foreach($privilegios as $val){
                if(strstr($url,$val)){
                    return $next($request);
                    // echo $url . "\n";
                    // echo $val . "\n\n";
                }
            }
            // return redirect('/')->with('error','No tiene permiso');
            // exit;
            echo "<pre>";
            // print_r($request->get());
            // dd(get_class_methods($request));
            print_r($privilegios);
            dd($url);
        }
    }
}