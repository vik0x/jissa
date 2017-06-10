<?php
Route::get('/administrador/idioma.html','idiomaController@index');
Route::get('/administrador/agregar/idioma.html','idiomaController@create');
Route::get('/administrador/mostrar/idioma{id}.html','idiomaController@show');
Route::post('/administrador/modificar/idioma{id}.html','idiomaController@edit');
Route::patch('/administrador/modificar/idioma{id}.html','idiomaController@update');
Route::put('/administrador/agregar/idioma.html','idiomaController@store');
Route::delete('/administrador/eliminar/idioma{id}.html','idiomaController@destroy');