<?php
Route::get('/administrador/rol.html','rolController@index');
Route::get('/administrador/agregar/rol.html','rolController@create');
Route::get('/administrador/mostrar/rol{id}.html','rolController@show');
Route::post('/administrador/modificar/rol{id}.html','rolController@edit');
Route::patch('/administrador/modificar/rol{id}.html','rolController@update');
Route::put('/administrador/agregar/rol.html','rolController@store');
Route::delete('/administrador/eliminar/rol{id}.html','rolController@destroy');