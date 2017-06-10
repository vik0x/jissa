<?php
Route::get('/administrador/restaurar/{modulo}{id}.html','papeleraController@show')->where(['modulo'=>'[a-zA-Z]+[a-zA-Z_]*','id'=>'[1-9]+[0-9]*']);
// Route::get('/administrador/papelera.html','papeleraController@index');
// Route::get('/administrador/agregar/papelera.html','papeleraController@create');
// Route::get('/administrador/mostrar/papelera{id}.html','papeleraController@show');
// Route::post('/administrador/modificar/papelera{id}.html','papeleraController@edit');
// Route::patch('/administrador/modificar/papelera{id}.html','papeleraController@update');
// Route::put('/administrador/guardar/papelera.html','papeleraController@store');
// Route::delete('/administrador/eliminar/papelera{id}.html','papeleraController@destroy');