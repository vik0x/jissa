<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class calendarioController extends Controller
{
    /**
     * Muestra las fechas en un calendario.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(){

        $data=[
            'slider' => \App\Models\front\slider_model::find_all(5),
        ];
        return view('front.calendario.show',$data);
        //
    }

}