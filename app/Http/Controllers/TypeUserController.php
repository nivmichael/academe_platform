<?php namespace App\Http\Controllers;

use DB;
use Response;
use Input;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;

use Illuminate\Http\Request;

class TypeUserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = DB::table('type_user')
		->get();
		
		return Response::json($users);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$id = Input::get('id');
		$param = User::find($id);
		if($param){
			$param->id = $id;	
		}else{
			$param = new User();
		}
		$param->type       = Input::get('type');
		$param->email      = Input::get('email');
		$param->password   = Hash::make(Input::get('password'));    
		//$param->password_new = Input::get('password_new');
		$param->first_name = Input::get('first_name');
		$param->last_name  = Input::get('last_name');
		$param->street_1   = Input::get('street_1');
		$param->street_2   = Input::get('street_2');
		$param->city 	   = Input::get('city');
		$param->state      = Input::get('state');
		$param->zipcode    = Input::get('zipcode');
		$param->country    = Input::get('country');
		$param->phone_1    = Input::get('phone_1');
		$param->phone_2    = Input::get('phone_2');
		$param->mobile     = Input::get('mobile');
		$param->date_of_birth  = Input::get('date_of_birth');
		$param->registration   = Input::get('registration');
		$param->send_newsletters  = Input::get('send_newsletters');
		$param->save();
		return Response::json($param);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::find($id);
		
		return Response::json($user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);	
		return Response::json($id);
	}

}
