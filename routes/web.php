<?php


Route::get('/', function () {
    return 'welcome';
});

Route::get('/usuarios', 'UserController@index')
     ->name('users.index');

Route::get('/usuarios/{user}', 'UserController@show')
     ->where('user', '[0-9]+')
     ->name('users.show');

Route::get('/usuarios/nuevo', 'UserController@create')                          // GET: Solicitar y obtener información
     ->name('users.create');

Route::post('/usuarios', 'UserController@store');                               // POST: Enviar y procesar información

Route::get('/usuarios/{user}/editar', 'UserController@edit')
     ->name('users.edit');

Route::put('/usuarios/{user}', 'UserController@update')
     ->name('users.update');

Route::delete('/usuarios/{user}', 'UserController@destroy')
     ->name('users.destroy');
