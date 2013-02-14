<?php

use Zend\Http\Request as Request;
use Zend\Http\Client as Client;

Route::get('/', 'HomeController@showWelcome');

// Route::get('/', function()
// {
// 	return View::make('home');
// });

Route::get('/login', function()
{
    return View::make('auth.login');
});
