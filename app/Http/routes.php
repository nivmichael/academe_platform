<?php

Blade::setEscapedContentTags('[[', ']]');
Blade::setContentTags('[[[', ']]]'); 


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


Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
  Route::get('/admin', 'AdminController@index');
});
Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');
        
Route::get('/employers', 'HomeController@index');
Route::get('/students' , 'HomeController@index');
Route::get('/graduates', 'HomeController@index');
Route::get('/interns'  , 'HomeController@index');



Route::get('/columns'    , 'ParamController@index');
//type_user_params CRUD
Route::PUT('/params/{id}'   , 'TypeUserParamController@update');
Route::get('/params'        , 'TypeUserParamController@index');
Route::post('/params'       , 'TypeUserParamController@store');
Route::delete('/params/{id}', 'TypeUserParamController@destroy');

//type_users CRUD
Route::PUT('/users/{id}'   , 'TypeUserController@update');
Route::get('/users'        , 'TypeUserController@index');
Route::get('/users/{id}'   ,'TypeUserController@show');
Route::post('/users'       , 'TypeUserController@store');
Route::delete('/users/{id}', 'TypeUserController@destroy');

Route::get('/getAuthId'    , function(){
	return Auth::id();
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

