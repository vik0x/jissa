<?php

namespace App\Http\Controllers\front\api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\front\sucursal_model as sucursal;

class indexModalsController extends Controller
{
    public function ciudades(Request $request){
        if($request->ajax()){
            echo json_encode(sucursal::get_cities($request->input('id')));
        }
        else
        abort(403);
    }

    public function sucursales(Request $request){
        if($request->ajax()){
            echo json_encode(sucursal::get_by_city($request->input('id')));
        }
        else
        abort(403);
    }

    public function lineas(Request $request){
        if($request->ajax()){
            echo json_encode(sucursal::get_by_sucursal($request->input('id')));
        }
        else
        abort(403);
    }
}