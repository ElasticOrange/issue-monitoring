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

Route::group(['middleware' => 'auth'], function(){

    Route::controller('admin', 'AdminDashboardController');

    Route::get('backend/legalnews/query', 'LegalNewsController@query');
    Route::get('backend/legalnews/{legalnews}/delete', 'LegalNewsController@destroy');
    Route::resource('backend/legalnews', 'LegalNewsController', ['except' => ['show', 'destroy']]);


    Route::get('backend/document/{public_code}/show', 'DocumentController@show');
    Route::get('backend/document/query', 'DocumentController@query');
    Route::get('backend/document/{document}/delete', 'DocumentController@destroy');
    Route::resource('/backend/document', 'DocumentController', ['except' => ['show', 'destroy']]);


    Route::get('file/{fileName}', 'UploadedFileController@downloadFile');

    Route::get('getTree', 'DomainController@getTree');
    Route::get('backend/domain/{domain}/edit', 'DomainController@edit');
    Route::get('backend/domain/{domain}/change-parent', 'DomainController@changeParent');
    Route::get('backend/domain/{domain}/delete', 'DomainController@destroy');
    Route::get('backend/domain/query-domain', 'DomainController@queryDomain');
    Route::resource('backend/domain', 'DomainController', ['except' => ['edit', 'destroy']]);


    Route::get('backend/stakeholder/{stakeholder}/delete', 'StakeholderController@destroy');
    Route::get('backend/stakeholder/query', 'StakeholderController@query');
    Route::get('backend/stakeholder/{public_code}/show', 'StakeholderController@show');
    Route::get('backend/stakeholder/query-list', 'StakeholderController@queryList');
    Route::get('backend/stakeholder/{stakeholder}/deleteFileCv', 'StakeholderController@deleteFileCv');
    Route::get('backend/stakeholder/{stakeholder}/deleteFilePoza', 'StakeholderController@deleteFilePoza');
    Route::get('backend/stakeholder/{stakeholder}/setPublished', 'StakeholderController@setPublished');
    Route::resource('backend/stakeholder', 'StakeholderController', ['except' =>['destroy', 'show']]);

    Route::get('getLocationTree', 'LocationController@getTree');
    Route::get('backend/location/{location}/edit', 'LocationController@edit');
    Route::get('backend/location/{location}/change-parent', 'LocationController@changeParent');
    Route::get('backend/location/{location}/delete', 'LocationController@destroy');
    Route::get('backend/location/query-location', 'LocationController@queryLocation');
    Route::resource('backend/location', 'LocationController', ['except' => ['edit', 'destroy']]);

    Route::get('backend/news/query', 'NewsController@query');
    Route::get('backend/news/{news}/delete', 'NewsController@destroy');
    Route::get('backend/news/{public_code}/show', 'NewsController@show');
    Route::get('backend/news/query-stakeholder', 'NewsController@queryStakeholder');
    Route::get('backend/news/query-domain', 'NewsController@queryDomain');
    Route::get('backend/news/query-tag', 'NewsController@queryTag');
    Route::get('backend/news/query-issue', 'NewsController@queryIssue');
    Route::get('backend/news/{news}/deleteFile', 'NewsController@deleteFile');
    Route::resource('backend/news', 'NewsController', ['except' => ['show', 'destroy']]);

    Route::get('backend/issue/{issue}/delete', 'IssueController@destroy');
    Route::get('backend/issue/{public_code}/show', 'IssueController@show');
    Route::get('backend/issue/query', 'IssueController@query');
    Route::get('backend/issue/query-domain', 'IssueController@queryDomain');
    Route::get('backend/issue/query-stakeholder', 'IssueController@queryStakeholder');
    Route::get('backend/issue/query-news', 'IssueController@queryNews');
    Route::get('backend/issue/query-issue', 'IssueController@queryIssue');
    Route::get('backend/issue/query-initiator', 'IssueController@queryInitiator');
    Route::get('backend/issue/query-location', 'IssueController@queryLocation');
    Route::get('backend/issue/query-document', 'IssueController@queryDocument');
    Route::get('backend/issue/query-step-autocomplete', 'IssueController@queryStepAutocomplete');
    Route::get('backend/issue/{issue}/setPublished', 'IssueController@setPublished');
    Route::resource('backend/issue', 'IssueController', ['except' => ['show', 'destroy']]);

    Route::post('backend/tag', 'TagController@store');

    Route::get('backend/stepautocomplete/query', 'StepAutocompleteController@query');
    Route::get('backend/stepautocomplete/{stepautocomplete}/delete', 'StepAutocompleteController@destroy');
    Route::resource(
        'backend/stepautocomplete',
        'StepAutocompleteController',
        ['except' => ['destroy', 'show', 'update', 'edit']]
    );

    Route::get('backend/flowtemplate/{flowtemplate}/get-full-template', 'FlowTemplateController@getFullTemplate');
    Route::get('backend/flowtemplate/{flowtemplate}/delete', 'FlowTemplateController@destroy');
    Route::resource('backend/flowtemplate', 'FlowTemplateController', ['except' => ['destroy']]);

    Route::get('users/profile', 'UserController@profile');
    Route::get('users/query', 'UserController@query');
    Route::post('users/profile', 'UserController@updateProfile');
    Route::get('users/{users}/delete', 'UserController@destroy');
    Route::get('users/query-domain', 'UserController@queryDomain');
    Route::resource('users', 'UserController', ['except' => ['destroy']]);
    Route::get('users/{users}/setPublished', 'UserController@setActive');

    Route::get('backend/alerte', 'AlertController@index');
    Route::get('backend/alerte/{id}/preview', 'AlertController@preview');

    Route::get('backend/report/query', 'ReportController@query');
    Route::get('backend/report/{report}/delete', 'ReportController@destroy');
    Route::get('backend/report/{public_code}/show', 'ReportController@show');
    Route::get('backend/report/{report}/deleteFile', 'ReportController@deleteFile');
    Route::resource('backend/report', 'ReportController', ['except' => ['show', 'destroy']]);
});



Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('issues', 'HomeController@getIssues');
Route::get('issues/{id}-{name}', 'HomeController@getIssueInfo');
Route::get('issues/news/{id}-{name}', 'HomeController@getNewsInfo');
Route::get('stakeholders/{id}-{name}', 'HomeController@getStakeholderInfo');
Route::get('stakeholders/news/{id}-{name}', 'HomeController@getAllStakeholderNews');
Route::get('stakeholders/issues/{id}-{name}', 'HomeController@getAllStakeholderIssues');
Route::get('stakeholders', 'HomeController@getStakeholders');
Route::get('reports', 'HomeController@getReports');
Route::get('contact', 'HomeController@getContact');
Route::post('contact', 'HomeController@postContact');
Route::get('about-us', 'HomeController@getAboutUs');
Route::get('services', 'HomeController@getServices');
Route::get('how-it-works', 'HomeController@howWorks');
Route::get('team', 'HomeController@getTeam');
Route::get('', 'HomeController@getIndex');

Route::get('email/issue/{id}-{name}', 'EmailViewController@getExternalIssueInfo');
Route::get('email/news/{id}-{name}', 'EmailViewController@getExternalNewsInfo');
Route::get('email/report/{id}-{name}', 'EmailViewController@getExternalReportInfo');
