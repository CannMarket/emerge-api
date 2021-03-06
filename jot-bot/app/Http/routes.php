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
    return view('index');
});


Route::group(['prefix' => '/'], function () {
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
	Route::post('authenticate', 'AuthenticateController@authenticate');
	
	Route::post('users', 'AuthenticateController@index');
	
	//Route::resource('dashboard', 'VisaAuthenticateController', ['only' => ['index']]);
	Route::get('dashboard/{id}','VisaAuthenticateController@dashboard');
	Route::get('contacts/{id}','VisaAuthenticateController@contacts');

	Route::resource('pullfunds', 'VisaAuthenticateController', ['only' => ['index']]);
	Route::post('pullfunds', 'VisaAuthenticateController@index');

	Route::resource('pushfunds', 'VisaAuthenticateController', ['only' => ['index']]);
	Route::post('pushfunds', 'VisaAuthenticateController@pushfunds');

	Route::resource('register', 'VisaAuthenticateController', ['only' => ['index']]);
	Route::post('register', 'VisaAuthenticateController@register');

	Route::resource('updatecard', 'VisaAuthenticateController', ['only' => ['index']]);
	Route::post('updatecard', 'VisaAuthenticateController@updatecard');
	Route::get('getcard/{id}','VisaAuthenticateController@getcard');

	Route::post('addcontact', 'VisaAuthenticateController@addcontact');
});

Route::group(['prefix' => 'api'], function()
{
	Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
	Route::post('authenticate', 'AuthenticateController@authenticate');

	Route::resource('pullfunds', 'VisaAuthenticateController', ['only' => ['index']]);
	Route::post('pullfunds', 'VisaAuthenticateController@index');

});
