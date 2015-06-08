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

Route::resource('/params', 'ParamController');
Route::resource('/users', 'TypeUserController');
Route::resource('/docParam', 'DocParamController');
Route::resource('/docType', 'DocTypeController');
Route::resource('/paramType', 'ParamTypeController');
Route::resource('/paramValue', 'ParamValueController');
Route::resource('/sysParamValues', 'sysParamValuesController');
Route::post('/sysParamValues/params', 'sysParamValuesController@saveParam');

Route::resource('auth/params', 'ParamController');
Route::resource('auth/users', 'TypeUserController');
Route::resource('auth/docParam', 'DocParamController');
Route::resource('auth/docType', 'DocTypeController');
Route::resource('auth/paramType', 'ParamTypeController');


Route::get('/columns/param'     , 'ParamController@columnIndex');
Route::get('/columns/user'      , 'TypeUserController@columnIndex');
Route::get('/columns/docParam'  , 'DocParamController@columnIndex');
Route::get('/columns/docType'   , 'DocTypeController@columnIndex');
Route::get('/columns/paramType' , 'ParamTypeController@columnIndex');
Route::get('/columns/paramValue' ,'ParamValueController@columnIndex');
Route::get('/columns/sysParamValues' ,'SysParamValuesController@columnIndex');



Route::get('/getAuthId'    , function(){
	return Auth::id();
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


//type_user_params CRUD
// Route::PUT('/params/{id}'   , 'ParamController@update');
// Route::get('/params'        , 'ParamController@index');
// Route::post('/params'       , 'ParamController@store');
// Route::delete('/params/{id}', 'ParamController@destroy');

//type_users CRUD
// Route::PUT('/users/{id}'   , 'TypeUserController@update');
// Route::get('/users'        , 'TypeUserController@index');
// Route::get('/users/{id}'   ,'TypeUserController@show');
// Route::post('/users'       , 'TypeUserController@store');
// Route::delete('/users/{id}', 'TypeUserController@destroy');