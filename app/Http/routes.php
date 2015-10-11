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

Route::get('/', function () {
    return view('welcome');
});


// Authentication routes...
//Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::get('auth/login/jobseeker', 'Auth\AuthController@getJobseekerLogin');
Route::get('auth/login/employer', 'Auth\AuthController@getEmployerLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::post('/auth/login', 'Auth\AuthController@postLogin');

// Registration routes...
Route::get('auth/register_employer', 'Auth\AuthController@getEmployerRegister');
Route::get('auth/register_jobseeker', 'Auth\AuthController@getjobseekerRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/columns/register_jobseeker', 'TypeUserController@columnIndexJobSeeker');
Route::get('/columns/register_employer', 'TypeUserController@columnIndexEmployer');

// Retrieve Authed User id
Route::get('/getAuthId', function(){
	return Auth::id();
});


Route::resource('/users', 'TypeUserController');
Route::any('/upload'        ,'SysParamValuesController@upload');
Route::post('/setStatus' ,'TypeUserController@setStatus');

// routes
Route::group(['middleware' => 'auth'], function () {
		

	Route::get('/groups', 'SysParamValuesController@getGroups');
	Route::get('/getAllJobs', 'TypePostController@index');
	Route::get('/columns/jobPost' ,'TypePostController@jobPostColumnIndex');
	Route::get('/job/{id}', 'TypePostController@show');		
	Route::get('/getAllPosts', 'TypePostController@getAllPosts');	
	
	Route::group(['middleware' => 'jobseeker'], function () {
		  Route::get('jobseeker', function () { return view('jobseeker_home'); });
		
	});	

	Route::group(['middleware' => 'employer'], function () {
		 Route::get('employer', function () {
	         return view('employer_home');
		 });
		 Route::post('/savePost', 'TypePostController@savePost');
	});		
		

	Route::group(['middleware' => 'admin'], function () {
	 
	
	    Route::get('admin', function () {
	         return view('admin');
	    });
		// Route::resource('/users', 'TypeUserController');
		Route::get('/columns/docParam'  , 'DocParamController@columnIndex');
		Route::get('/columns/docType'   , 'DocTypeController@columnIndex');
		Route::get('/columns/paramType' , 'ParamTypeController@columnIndex');
		Route::get('/columns/paramValue' ,'ParamValueController@columnIndex');
		Route::get('/columns/sysParamValues' ,'SysParamValuesController@columnIndex');
		Route::get('/columns/user', 'TypeUserController@columnIndex');
		Route::get('/columns/param'     , 'ParamController@columnIndex');
		Route::resource('/params', 'ParamController');
		
		Route::resource('/docParam', 'DocParamController');
		Route::resource('/docType', 'DocTypeController');
		Route::resource('/paramType', 'ParamTypeController');
		Route::resource('/paramValue', 'ParamValueController');
		Route::resource('/sysParamValues', 'sysParamValuesController');
	});
	
});