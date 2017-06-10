<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\front\pagina_model as pagina;

class paginaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        $slug = explode(url() . '/', \Request::url());
        $slug = end($slug);

        $pagina = pagina::get_page($slug);

        if(is_object($pagina)){
            $data = array(
                'pagina' => $pagina
            );

            //dd($pagina);

            return view('front.pagina',$data);
        }
        abort(404);
    }

}
