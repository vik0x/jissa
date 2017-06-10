<?php
Route::get('/administrador/usuario.html','usuarioController@index');
Route::get('/administrador/agregar/usuario.html','usuarioController@create');
Route::get('/administrador/mostrar/usuario{id}.html','usuarioController@show');
Route::post('/administrador/modificar/usuario{id}.html','usuarioController@edit');
Route::patch('/administrador/modificar/usuario{id}.html','usuarioController@update');
Route::put('/administrador/agregar/usuario.html','usuarioController@store');
Route::delete('/administrador/eliminar/usuario{id}.html','usuarioController@destroy');