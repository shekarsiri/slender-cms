<?php


// Route::group(array('prefix' => 'admin'), function()
// {


    // Resource without Auth
    Route::resource('login', 'LoginController');


    // Resources with Auth
    Route::group(array('before' => 'auth'), function()
    {
        Route::get('/', 'HomeController@index');

        Route::resource('sites', 'SitesController');
        Route::resource('users', 'UsersController');
        Route::resource('roles', 'RolesController');
        Route::resource('videos', 'VideosController');
        

        //Route::get('password/forgot', array('uses' => 'PasswordController@forgot', 'as' => 'forgotpassword'));
        //Route::post('password/send', array('uses' => 'PasswordController@send', 'as' => 'sendpassword'));
        //Route::any('password/reset/{data}', array('uses' => 'PasswordController@reset', 'as' => 'resetpassword'));

        // Route::any('sites', 'SitesController@index');
    });

Route::get('password/forgot', array('uses' => 'PasswordController@forgot', 'as' => 'forgotpassword'));
Route::post('password/send', array('uses' => 'PasswordController@send', 'as' => 'sendpassword'));
Route::any('password/reset/{data}', array('uses' => 'PasswordController@reset', 'as' => 'resetpassword'));



// });

