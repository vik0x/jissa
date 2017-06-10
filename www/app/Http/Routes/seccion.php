<?php
Route::get('/administrador/seccion.html','seccionController@index');
Route::get('/administrador/agregar/seccion.html','seccionController@create');
Route::get('/administrador/mostrar/seccion{id}.html','seccionController@show');
Route::post('/administrador/modificar/seccion{id}.html','seccionController@edit');
Route::patch('/administrador/modificar/seccion{id}.html','seccionController@update');
Route::put('/administrador/agregar/seccion.html','seccionController@store');
Route::delete('/administrador/eliminar/seccion{id}.html','seccionController@destroy');