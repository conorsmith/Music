<?php

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@home',
]);

Route::get('albums', [
    'as' => 'albums',
    'uses' => 'HomeController@albums',
]);

Route::get('artists', [
    'as' => 'artists',
    'uses' => 'HomeController@artists',
]);

Route::group(['middleware' => "auth"], function () {
    Route::get('dashboard', 'AdminController@dashboard');
    Route::post('update', 'AdminController@update');

    Route::post('auth/trigger', [
        'as' => 'auth.trigger',
        'uses' => 'Auth\GoogleAuthController@trigger',
    ]);
});

Route::group(['middleware' => "guest"], function () {
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
});

Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/callback', [
    'as' => 'auth.callback',
    'uses' => 'Auth\GoogleAuthController@callback',
]);
