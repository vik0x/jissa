<?php
Route::get('/administrador/permiso.html','permisoController@index');
Route::get('/administrador/agregar/permiso.html','permisoController@create');
Route::get('/administrador/mostrar/permiso{id}.html','permisoController@show');
Route::post('/administrador/modificar/permiso{id}.html','permisoController@edit');
Route::patch('/administrador/modificar/permiso{id}.html','permisoController@update');
Route::put('/administrador/guardar/permiso.html','permisoController@store');
Route::delete('/administrador/eliminar/permiso{id}.html','permisoController@destroy');