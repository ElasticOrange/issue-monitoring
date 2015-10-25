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

Route::controller('/admin', 'AdminDashboardController');

Route::resource('/backend/document', 'DocumentController');

Route::get('/', 'DocumentController@index');

Route::get('/document/{file_name}', 'DocumentController@downloadDocument');

Route::get('/backend/domain/{domain}/edit', 'DomainController@edit');
Route::get('/backend/domain/{domain}/delete', 'DomainController@destroy');
Route::resource('/backend/domain', 'DomainController', ['except' => ['edit', 'destroy']]);

Route::get('/getTree', 'DomainController@getTree');