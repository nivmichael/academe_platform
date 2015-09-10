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

Route::group(['middleware' => 'App\Http\Middleware\EmployerMiddleware'], function()
{
  Route::get('/employer', 'EmployerController@index');
});

Route::group(['middleware' => 'App\Http\Middleware\HomeMiddleware'], function()
{
  Route::get('/home', 'HomeController@index');
});

 // Route::get('/home', 'HomeController@index');


Route::get('/', 'WelcomeController@index');
// Route::get('home', 'HomeController@index');
        
// Route::get('/employers', 'HomeController@index');
// Route::get('/students' , 'HomeController@index');
// Route::get('/graduates', 'HomeController@index');
// Route::get('/interns'  , 'HomeController@index');

// Route::post('/adminStore', 'TypeUserController@adminStore');
Route::resource('/params', 'ParamController');
Route::resource('/users', 'TypeUserController');

Route::resource('/docParam', 'DocParamController');
Route::resource('/docType', 'DocTypeController');
Route::resource('/paramType', 'ParamTypeController');
Route::resource('/paramValue', 'ParamValueController');
Route::resource('/sysParamValues', 'sysParamValuesController');
Route::post('/sysParamValues/params', 'sysParamValuesController@saveParam');
Route::post('/savePost', 'TypePostController@savePost');
Route::get('/getAllJobs', 'TypePostController@index');
Route::get('/job/{id}', 'TypePostController@show');
Route::get('/inputType', 'TypePostController@getInputType');
Route::get('/groups', 'SysParamValuesController@getGroups');
// Route::resource('/job/[id]', 'TypePostController');


// Route::resource('auth/params', 'ParamController');
// Route::resource('auth/users', 'TypeUserController');
// Route::resource('auth/docParam', 'DocParamController');
// Route::resource('auth/docType', 'DocTypeController');
// Route::resource('auth/paramType', 'ParamTypeController');

Route::get('/columns/param'     , 'ParamController@columnIndex');
Route::get('/columns/user', 'TypeUserController@columnIndex');
Route::get('/columns/registerEmployer', 'TypeUserController@columnIndexEmployer');
// Route::get('/columns/{docParamName}', 'DocParamController@getCompanyParamInput');
Route::get('/columns/registerJobSeeker', 'TypeUserController@columnIndexJobSeeker');
Route::get('/columns/docParam'  , 'DocParamController@columnIndex');
Route::get('/columns/docType'   , 'DocTypeController@columnIndex');
Route::get('/columns/paramType' , 'ParamTypeController@columnIndex');
Route::get('/columns/paramValue' ,'ParamValueController@columnIndex');
Route::get('/columns/sysParamValues' ,'SysParamValuesController@columnIndex');
Route::get('/columns/jobPost' ,'TypePostController@jobPostColumnIndex');

// Route::get('/columns/{doc_param}' ,'DocParamController@getParams');

Route::any('/upload'        ,'SysParamValuesController@upload');
Route::any('/deleteImage'   ,'SysParamValuesController@deleteimagefromdb');
Route::post('/setStatus' ,'TypeUserController@setStatus');
Route::post('/deleteIterable' ,'SysParamValuesController@deleteIterable');
Route::get('/getStatus' ,'TypeUserController@getStatus');


Route::get('auth/login_employer', 'Auth\AuthController@getLoginEmployer');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('/getAuthId', function(){
	return Auth::id();
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



?>

