<?php
Route::get('/administrador/modulo.html','moduloController@index');
Route::get('/administrador/agregar/modulo.html','moduloController@create');
Route::get('/administrador/mostrar/modulo{id}.html','moduloController@show');
Route::post('/administrador/modificar/modulo{id}.html','moduloController@edit');
Route::patch('/administrador/modificar/modulo{id}.html','moduloController@update');
Route::put('/administrador/agregar/modulo.html','moduloController@store');
Route::delete('/administrador/eliminar/modulo{id}.html','moduloController@destroy');