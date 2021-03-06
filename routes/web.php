<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'TaplistController@index');

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'can:admin'], function() {
    Route::resource('beer', 'BeerController');
    Route::post('/beer/{beer}/reloadratebeer', 'BeerController@reloadRatebeerRating');
    Route::post('/beer/{beer}/reloaduntappd', 'BeerController@reloadUntappdRating');
    Route::get('/beer/{beer}/untappdsearch', 'BeerController@getUntappdMatches');
    Route::resource('users', 'UserController');
});
