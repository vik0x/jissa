<?php

namespace App\Http\Controllers\front\api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class favouritesController extends Controller{
    
    public function add( Request $request ){
        
        $response = new \stdClass();

        try{

            $itemid = $request->input('itemid');
            $action = $request->input('action');

            $cookie_name  = 'fav_items_raqyv';

            if( ! $itemid || ! $action )
                throw new \Exception("Datos inválidos", 1);

            if( $action == "add" ){

                //-----> Creamos la COOKIE
                if( ! isset( $_COOKIE[ $cookie_name ] ) ){

                    setcookie('fav_items_raqyv', $itemid);
                    $_COOKIE["fav_items_raqyv"] = $itemid;

                }else{

                    $da_cookie = explode(",", $_COOKIE["fav_items_raqyv"]); 
                    
                    if( ! in_array( $itemid, $da_cookie) )
                        $da_cookie[] = $itemid;

                    setcookie('fav_items_raqyv', implode(",", $da_cookie) );  
                    $_COOKIE["fav_items_raqyv"] = implode(",", $da_cookie);            

                }

            }elseif( $action == "remove" ){

                $da_cookie = explode(",", $_COOKIE["fav_items_raqyv"]); 

                if (($key = array_search($itemid, $da_cookie)) !== false) {
                    unset($da_cookie[$key]);
                }

                setcookie($cookie_name, implode(",", $da_cookie));
                $_COOKIE["fav_items_raqyv"] = implode(",", $da_cookie);             

            }else
                throw new \Exception("Acción incorrecta", 1);
                
            $response->code     = 0;
            $response->status   = TRUE;
            $response->message  = "Acción ejectutada correctamente";

        }catch( \Exception $e ){

            $response->code     = $e->getCode();
            $response->status   = FALSE;
            $response->message  = $e->getMessage();
            $response->line     = $e->getLine();

        }

        print json_encode( $response );
        exit();

    }

   
}
