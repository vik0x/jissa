<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
include_once('Routes/auth.php');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/',function(){return view('layout.admin');});
	Route::get('/administrador', function () {return view('layout.admin');});
	Route::patch('/administrador/listar/{modulo}.html','generalController@listar')->where(['modulo'=>'[a-zA-Z]+[a-zA-Z_]*']);

	//Pagado y Acumulado por pagar
	Route::group(['middleware' => 'permisos'], function() {
		Route::post('/administrador/estatus/{modulo}.html','generalController@estatus');
		Route::delete('/administrador/eliminar/{modulo}{id}.html','generalController@destroy')->where(['modulo'=>'[a-zA-Z]+[a-zA-Z_]*','id'=>'[1-9]+[0-9]*']);
		Route::post('/administrador/restaurar/{modulo}{id}.html','generalController@restore')->where(['modulo'=>'[a-zA-Z]+[a-zA-Z_]*','id'=>'[1-9]+[0-9]*']);
		// Route::get('/administrador/mostrar/{modulo}{id}.html','generalController@show')->where(['modulo'=>'[a-zA-Z]+[a-zA-Z_]*','id'=>'[1-9]+[0-9]*']);


		include_once('Routes/dash.php');
		include_once('Routes/idiomas.php');
		include_once('Routes/modulo.php');
		include_once('Routes/papelera.php');
		include_once('Routes/permiso.php');
		include_once('Routes/privilegio.php');
		include_once('Routes/rol.php');
		include_once('Routes/seccion.php');
		include_once('Routes/usuario.php');

	});
});