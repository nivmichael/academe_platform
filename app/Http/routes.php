<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['domain' => 'localhost'], function(){

});

Route::group(['middleware' => ['web','domain']], function () {

    Route::get('/', function () { return view('index'); });
    Route::get('layout', 'SitesController@getLayout');
    Route::group(['prefix' => 'api'], function()
    {
        Route::get('/jobseekerSteps', 'DocParamController@jobseekerSteps');
        Route::get('/employerSteps', 'DocParamController@employerSteps');
        Route::get('/forms/register_jobseeker', 'TypeUserController@columnIndexJobSeeker');
        Route::get('/forms/register_employer', 'TypeUserController@columnIndexEmployer');
        Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
        Route::get('auth/unlink/{provider}', ['middleware' => 'auth', 'uses' => 'AuthController@unlink']);
        Route::get('/password/email', 'Auth\PasswordController@getEmail');
        Route::post('/password/email', 'Auth\PasswordController@postEmail');
        // Password reset routes...
        Route::get('/password/reset/{token}', 'Auth\PasswordController@getReset');
        Route::post('/password/reset', 'Auth\PasswordController@postReset');
        Route::post('/authenticate', 'AuthenticateController@authenticate');
        Route::post('/signup', 'AuthenticateController@signup');
        //Route::get('/me', 'TypeUserController@index');
        Route::get('/me', 'TypeUserController@index');
        Route::post('/me', 'TypeUserController@updateUser');
        Route::get('/getAllPosts', 'PostController@index');
        Route::get('/getAllOptionValues', 'ParamValueController@getAllOptionValues');
        Route::get('/columns/jobPost' ,'TypePostController@jobPostColumnIndex');
        Route::post('/savePost', 'PostController@savePost');
    });
    // Password reset link request routes...
    Route::get('/password/email', 'Auth\PasswordController@getEmail');
    Route::post('/password/email', 'Auth\PasswordController@postEmail');

    // Password reset routes...
    Route::get('/password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('/password/reset', 'Auth\PasswordController@postReset');
    Route::post('verifyToken', 'Auth\PasswordController@verifyToken');
    Route::post('/setStatus' ,'TypeUserController@setStatus');
    Route::get('/param/{paramName}/{docParamId}/{isPost?}', ['as'=>'whatever','uses'=>'ParamValueController@getOptionValues']);
});

