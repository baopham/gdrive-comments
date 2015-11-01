<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return redirect('/gdrive');
});

Route::get('/auth/login', function () {
    return redirect('/auth/google');
});

Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/google', 'Auth\AuthController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\AuthController@handleProviderCallback');

Route::group(['middleware' => 'auth', 'prefix' => 'gdrive'], function () {
    Route::get('/', 'GDriveFileController@index');

    Route::post('get-comments', 'GDriveFileController@getCommentsByFileId');

    Route::get('files/{id}', 'GDriveFileController@show');

    Route::get('files/{id}/edit', 'GDriveFileController@edit');

    Route::put('files/{id}', 'GDriveFileController@update');

    Route::delete('files/{id}', 'GDriveFileController@destroy');
});
