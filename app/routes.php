<?php

// Resource without Auth
Route::resource('login', 'LoginController');

// Resources with Auth
Route::group(array('before' => 'auth'), function()
{
    Route::resource('/', 'HomeController');
});
