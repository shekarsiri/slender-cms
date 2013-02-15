<?php

// throw new Dws\Slender\Api\ApiException('aaa');

// Resource without Auth
Route::resource('login', 'LoginController');

Route::any('users', 'UsersController@index');
Route::get('users/{id}', 'UsersController@show');
Route::post('users/{id}', 'UsersController@update');
Route::any('users/{id}/destroy', 'UsersController@destroy');

Route::any('roles', 'RolesController@index');
Route::get('roles/{id}', 'RolesController@show');
Route::post('roles/{id}', 'RolesController@update');
Route::get('roles/create', 'RolesController@create');
Route::post('roles/create', 'RolesController@store');
Route::any('roles/{id}/destroy', 'RolesController@destroy');

Route::any('sites', 'SitesController@index');

// Resources with Auth
Route::group(array('before' => 'auth'), function()
{
    Route::resource('/', 'HomeController');
});
