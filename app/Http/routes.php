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
    Route::get('dashboard', "Admin\ShowDashboard@__invoke");
    Route::get('weeks-albums/new', "Admin\ShowNewWeeksAlbumsForm@__invoke");
    Route::get('admin/albums', "Admin\ListAlbums@__invoke");
    Route::get('admin/album/{id}', "Admin\ShowAlbumForm@__invoke");

    Route::post('weeks-albums', "Admin\CreateWeeksAlbums@__invoke");
    Route::put('album/{id}', "Admin\ModifyAlbum@__invoke");
    Route::post('album/{id}/rating', "Admin\CreateAlbumRating@__invoke");
    Route::post('update', "Admin\ImportFromGoogleSheets@__invoke");

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
