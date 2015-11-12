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
Route::get('/', 'DocumentController@index');

Route::controller('/admin', 'AdminDashboardController');

Route::get('/backend/document/{public_code}/show', 'DocumentController@show');
Route::get('/backend/document/{document}/delete', 'DocumentController@destroy');
Route::resource('/backend/document', 'DocumentController', ['except' => ['show', 'destroy']]);


Route::get('/file/{fileName}', 'UploadedFileController@downloadFile');

Route::get('/getTree', 'DomainController@getTree');
Route::get('/backend/domain/{domain}/edit', 'DomainController@edit');
Route::get('/backend/domain/{domain}/changeparent', 'DomainController@changeParent');
Route::get('/backend/domain/{domain}/delete', 'DomainController@destroy');
Route::resource('/backend/domain', 'DomainController', ['except' => ['edit', 'destroy']]);


Route::get('/backend/stakeholder/{stakeholder}/delete', 'StakeholderController@destroy');
Route::get('/backend/stakeholder/{public_code}/show', 'StakeholderController@show');
Route::get('/backend/stakeholder/query-list', 'StakeholderController@queryList');
Route::resource('/backend/stakeholder', 'StakeholderController', ['except' =>['destroy', 'show']]);
Route::get('/backend/stakeholder/{stakeholder}/setPublished', 'StakeholderController@setPublished');

Route::get('/getLocationTree', 'LocationController@getTree');
Route::get('/backend/location/{location}/edit', 'LocationController@edit');
Route::get('/backend/location/{location}/changeparent', 'LocationController@changeParent');
Route::get('/backend/location/{location}/delete', 'LocationController@destroy');
Route::resource('/backend/location', 'LocationController', ['except' => ['edit', 'destroy']]);

Route::get('/backend/news/{news}/delete', 'NewsController@destroy');
Route::get('/backend/news/{public_code}/show', 'NewsController@show');
Route::get('/backend/news/query-stakeholder', 'NewsController@queryStakeholder');
Route::get('/backend/news/query-domain', 'NewsController@queryDomain');
Route::get('/backend/news/query-tag', 'NewsController@queryTag');
Route::resource('/backend/news', 'NewsController', ['except' => ['show', 'destroy']]);

Route::get('/backend/issue/{issue}/delete', 'IssueController@destroy');
Route::get('/backend/issue/{public_code}/show', 'IssueController@show');
Route::get('/backend/issue/query-domain', 'IssueController@queryDomain');
Route::get('/backend/issue/query-stakeholder', 'IssueController@queryStakeholder');
Route::get('/backend/issue/query-news', 'IssueController@queryNews');
Route::get('/backend/issue/query-issue', 'IssueController@queryIssue');
Route::resource('/backend/issue', 'IssueController', ['except' => ['show', 'destroy']]);

Route::post('/backend/tag', 'TagController@store');
