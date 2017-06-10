<?php
Route::get('/administrador/privilegio{id}.html','privilegioController@index');
Route::get('/administrador/agregar/privilegio{id}.html','privilegioController@create');
Route::get('/administrador/mostrar/privilegio{id}.html','privilegioController@show');
Route::post('/administrador/modificar/privilegio{id}.html','privilegioController@edit');
Route::patch('/administrador/modificar/privilegio{id}.html','privilegioController@update');
Route::put('/administrador/agregar/privilegio{id}.html','privilegioController@store');
Route::delete('/administrador/eliminar/privilegio{id}.html','privilegioController@destroy');