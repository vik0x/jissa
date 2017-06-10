<?php
Route::get('/login.html','loginController@index');
Route::get('/cerrar.html','loginController@destroy');
Route::put('/validar/session.html','loginController@store');