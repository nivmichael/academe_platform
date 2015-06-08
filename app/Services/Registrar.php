<?php namespace App\Services;

use Hash;
use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:type_user',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			
			// 'type'             => $data['type'],
			'first_name'       => $data['first_name'],
			'last_name'        => $data['last_name'],
			'email'            => $data['email'],
			'password'         => Hash::make($data['password']),
			'street_1'         => $data['street_1'],
			'street_2'    	   => $data['street_2'],
			'city'        	   => $data['city'],
			'state'       	   => $data['state'],
			'country'          => $data['country'],
			'zipcode'     	   => $data['zipcode'],
			'phone_1'     	   => $data['phone_1'],
			'phone_2'     	   => $data['phone_2'],
			'mobile'      	   => $data['mobile'],
		    'date_of_birth'    => $data['date_of_birth'],
			// 'registration'     => $data['registration'],
			//'send_newsletters' => $data['send_newsletters']
		]);
	}

}
